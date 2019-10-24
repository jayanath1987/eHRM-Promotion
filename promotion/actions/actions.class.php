<?php

/**
 * Actions class for Promotion Module
 *
 * -------------------------------------------------------------------------------------------------------
 *  Author    - Jayanath Liyanage
 *  On (Date) - 07 September 2011 
 *  Comments  - Employee Promotion Functions 
 *  Version   - Version 1.0
 * -------------------------------------------------------------------------------------------------------
 * */
include ('../../lib/common/LocaleUtil.php');

class PromotionActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeListPromotion(sfWebRequest $request) {
        try {
            $this->culture = $this->getUser()->getCulture();
            $this->var = 0;
            $promotionDao = new promotionDao();
            $this->pDao = $promotionDao;
            $promotionSubService =new promotionSubService();
           

            $this->sorter = new ListSorter('Promotion', 'promotion', $this->getUser(), array('p.prm_id', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array($this->getContext()->getI18N()->__('Select the field to search', $args, 'messages')));
                    $this->redirect('promotion/listPromotion');
                }
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'p.prm_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $promotionSubService->getPromotionList($this->searchMode, $this->searchValue, $this->culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->listPromotion = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');

        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeSavePromotion(sfWebRequest $request) {

        $this->culture = $this->getUser()->getCulture();
        $promotionDao = new promotionDao();
        $this->promotionDao = new promotionDao();
        $promotionService=new promotionService();
        if($request->getParameter('update')=="yes"){
        if (!strlen($request->getParameter('lock'))) {
            $this->lockMode = 0;
        } else {
            $this->lockMode = $request->getParameter('lock');
        }
        $Promotionid = $request->getParameter('id');
        if (isset($this->lockMode)) {
            if ($this->lockMode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_promotion', array($Promotionid), 1);

                if ($recordLocked) {
                    // Display page in edit mode
                    $this->lockMode = 1;
                } else {
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                    $this->lockMode = 0;
                }
            } else if ($this->lockMode == 0) {
                $conHandler = new ConcurrencyHandler();
                $recordLocked = $conHandler->resetTableLock('hs_hr_promotion', array($Promotionid), 1);
                $this->lockMode = 0;
            }
            
         $this->promotion = $promotionService->readPromotion($Promotionid);
         $promotion=$this->promotion;
         
        if (!$promotion) {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
            $this->redirect('promotion/listPromotion');
        }
           $this->update="Update"; 
           $promotion=$this->promotion;
         $this->salaryslot=$promotionService->getGradeSlotLoadID($promotion->prm_prev_slt_id,$promotion->grade_code);
         $this->salary=$promotionService->getGradeSlot($promotion->prm_prev_slt_id);
         
        }
        }else{
            $this->update="";
        }
        

        $this->employedata = $promotionService->getEmployeerecord('1');
        $this->promotiona = $promotionService->getPrmfrmLoadGrd();
        $this->promotiondesc = $promotionService->getPrmfrmLoadDesc();
        $this->promotionemptype = $promotionService->getPrmfrmLoadEType();
        $this->promotionservice = $promotionService->getPrmfrmLoadPMsevice();
        $this->promotionMethod = $promotionService->getPrmfrmLoadPMethod();
        $this->Class = $promotionService->getClassLoad();
        $this->Grade = $promotionService->getGradeLoad();
        $this->Level = $promotionService->getLevelLoad();
        
        if ($request->isMethod('post')) { 
            if($this->update=="Update"){
               $promotion = $promotionService->readPromotion($Promotionid); 
            }
            else{
            $promotion = new Promotion();
            }

            try {


                $sysConfinst = OrangeConfig::getInstance()->getSysConf();
                $sysConfs = new sysConf();

                if (array_key_exists('txtletter', $_FILES)) {
                    foreach ($_FILES as $file) {

                        if ($file['tmp_name'] > '') {
                            if (!in_array(end(explode(".", strtolower($file['name']))), $sysConfs->allowedExtensions)) {
                                throw new Exception("Invalid File Type", 8);
                            }
                        }
                    }
                } else {
                    throw new Exception("Invalid File Type", 6);
                }

                $fileName = $_FILES['txtletter']['name'];
                $tmpName = $_FILES['txtletter']['tmp_name'];
                $fileSize = $_FILES['txtletter']['size'];
                $fileType = $_FILES['txtletter']['type'];


                $maxFileSize2 = $sysConfs->getMaxFilesize();
                $sysConfinst = OrangeConfig::getInstance()->getSysConf();
                $sysConfs = new sysConf();
                //$maxsize=2097152;
                if ($fileSize > $maxFileSize2) {

                    throw new Exception("Maxfile size  Should be less than 2MB", 1);
                }
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/listPromotion');
            }
            try {
                $Employee=$promotionDao->getEmployee($request->getParameter('txtEmpId'));
                
                $fp = fopen($tmpName, 'r');
                $content = fread($fp, filesize($tmpName));
                $content = addslashes($content);
                $promotion->setEmp_number((int) ($request->getParameter('txtEmpId')));

                if ($request->getParameter('cmbDesg') != -1) {
                    $desg = $request->getParameter('cmbDesg');
                    $promotion->setPrm_prev_jobtit_code($Employee['job_title_code']);
                } else if ($request->getParameter('txtcdesg') != null) {
                    $desg = $request->getParameter('txtcdesg');
                    $promotion->setPrm_prev_jobtit_code($Employee['job_title_code']);
                } else {
                    $desg = null;
                }
                $promotion->setJobtit_code($desg);
                
                if (($request->getParameter('cmbEType')) != -1) {
                    $esta = $request->getParameter('cmbEType');
                    $promotion->setPrm_prev_emp_status($Employee['emp_status']);
                } else if (($request->getParameter('txtcetype')) != null) {
                    $esta = $request->getParameter('txtcetype');
                    $promotion->setPrm_prev_emp_status($Employee['emp_status']);
                } else {
                    $esta = null;
                }
                $promotion->setEstat_code($esta);
                
                if ((int) $request->getParameter('cmbLevel') != -1) {
                    $Level = $request->getParameter('cmbLevel');
                    $promotion->setPrm_prev_level_code($Employee['level_code']);
                } else if ($request->getParameter('txtGrade') != null) {
                    $Level = $request->getParameter('txtGrade');
                    $promotion->setPrm_prev_level_code($Employee['level_code']);
                } else {
                    $Level = null;
                }
                $promotion->setLevel_code($Level);
                
                if (((int) $request->getParameter('cmbService')) != -1) {
                    $service= $request->getParameter('cmbService');
                    $promotion->setPrm_prev_service_code($Employee['service_code']);
                } else if ( $request->getParameter('Service') != null) {
                    $service= $request->getParameter('Service');
                    $promotion->setPrm_prev_service_code($Employee['service_code']);
                } else {
                    $service = null;
                }
                $promotion->setService_code($service);
                
                if (((int) $request->getParameter('cmbClass')) != -1) {
                    $class= $request->getParameter('cmbClass');
                    $promotion->setPrm_prev_class_code($Employee['class_code']);
                } else if ($request->getParameter('txtClass') != null) {
                    $class= $request->getParameter('txtClass');
                    $promotion->setPrm_prev_class_code($Employee['class_code']);
                } else {
                    $class = null;
                }
                $promotion->setClass_code($class);
                
                if ((int) $request->getParameter('cmbGrade') != -1) {
                    $grade = $request->getParameter('cmbGrade');
                    $promotion->setPrm_prev_grade($Employee['grade_code']);
                } else if ($request->getParameter('txtGrade') != null) {
                    $grade = $request->getParameter('txtGrade');
                    $promotion->setPrm_prev_grade($Employee['grade_code']);
                } else {
                    $grade = null;
                }
                $promotion->setGrade_code($grade);
                
                if (((int) $request->getParameter('cmbGradeSlot')) != -1) {
                    $gradeslot = $request->getParameter('cmbGradeSlot');
                    $promotion->setPrm_prev_slt_id($Employee['slt_scale_year']);
                } else if ($request->getParameter('txtcgrd') != null) {
                    $gradeslot = $request->getParameter('txtcgrd');
                    $promotion->setPrm_prev_slt_id($Employee['slt_scale_year']);
                } else {
                    $gradeslot = null;
                }
                $promotion->setSlt_id($gradeslot);
                
                if (($request->getParameter('txtIncrementDate')) != null) {
                    $incrementdate = LocaleUtil::getInstance()->convertToStandardDateFormat($request->getParameter('txtIncrementDate'));
                    $promotion->setPrm_prev_emp_salary_inc_date($Employee['emp_salary_inc_date']);
                } else if(($request->getParameter('IncrementDate')) != null){
                    $incrementdate  = LocaleUtil::getInstance()->convertToStandardDateFormat($request->getParameter('IncrementDate'));
                    $promotion->setPrm_prev_emp_salary_inc_date($Employee['emp_salary_inc_date']);
                }else{
                    $incrementdate = null;
                }
                $promotion->setEmp_salary_inc_date($incrementdate);

                if (($request->getParameter('txtNWorkStaion')) != null) {
                    $worksatation = $request->getParameter('txtNWorkStaion');
                    $promotion->setPrm_prev_work_station($Employee['work_station']);
                } else {
                    $worksatation = $request->getParameter('txtWorkStation');
                    $promotion->setPrm_prev_work_station($Employee['work_station']);
                }
                $promotion->setPrm_divition($worksatation);



                if ($request->getParameter('effdate') != null) {
                    $promotion->setPrm_effective_date(LocaleUtil::getInstance()->convertToStandardDateFormat($request->getParameter('effdate')));
                } else {
                    $promotion->setPrm_effective_date(null);
                }
                
                if ($request->getParameter('txtCommencementdate') != null) {
                    $promotion->setPrm_commencement_date(LocaleUtil::getInstance()->convertToStandardDateFormat($request->getParameter('txtCommencementdate')));
                } else {
                    $promotion->setPrm_commencement_date(null);
                }
                
                 if ($request->getParameter('txtprmmethod') == -1) {
                    $promotion->setPrm_method_id(null);
                } else {
                    $promotion->setPrm_method_id($request->getParameter('txtprmmethod'));
                }
                
                $promotion->setPrm_comment(trim($request->getParameter('comment')));
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $promotionService->saveNewPromotion($promotion);
                if (strlen($content)) {

                    
                    if(!strlen($Promotionid)){
                        $Prmattach = new PromotionAttachment();                     
                            $Prmattach->setPrm_attach_filename($fileName);
                            $Prmattach->setPrm_attach_type($fileType);
                            $Prmattach->setPrm_attach_size($fileSize);
                            $Prmattach->setPrm_attach_attachment($content);
                            $lastprmid = $promotionDao->getLastPromotionID();
                            $Prmattach->setPrm_id($lastprmid[0]['MAX']);
                            $promotionService->saveNewAttachment($Prmattach);

                    }else{
                        $caprmid = $promotionDao->readattach($Promotionid);
                        if ($caprmid[0]['count'] == 1) {
                            $abcc = $promotionDao->updatch($Promotionid);
                            $Prmattach = new PromotionAttachment();
                            $Prmattach->setPrm_id($Promotionid);
                            $Prmattach->setPrm_attach_filename($fileName);
                            $Prmattach->setPrm_attach_type($fileType);
                            $Prmattach->setPrm_attach_size($fileSize);
                            $Prmattach->setPrm_attach_attachment($content);
                            $promotionService->saveNewAttachment($Prmattach);
                        } else {
                            $Prmattach = new PromotionAttachment();                     
                            $Prmattach->setPrm_attach_filename($fileName);
                            $Prmattach->setPrm_attach_type($fileType);
                            $Prmattach->setPrm_attach_size($fileSize);
                            $Prmattach->setPrm_attach_attachment($content);
                            $Prmattach->setPrm_id($Promotionid);
                            $promotionService->saveNewAttachment($Prmattach);

                        }
                    }
                }

                
                $e = getdate();
                $today = date("Y-m-d", $e[0]);
                if($today >= LocaleUtil::getInstance()->convertToStandardDateFormat($request->getParameter('effdate'))){
                    
                 $varibleList=array();
                 $varibleList['id']=$request->getParameter('txtEmpId');
                 $varibleList['desg']=$desg;
                 $varibleList['esta']=$esta;
                 $varibleList['Level']=$Level;
                 $varibleList['service']=$service;
                 $varibleList['class']=$class;
                 $varibleList['grade']=$grade;
                 $varibleList['gradeslot']=$gradeslot;
                 $varibleList['incrementdate']=$incrementdate;
                 $varibleList['worksatation']=$worksatation;
                 


                $promotionService->updateEmpMaster($varibleList);
                $Employee=$promotionService->getEmployee($request->getParameter('txtEmpId'));
                /* update def_level */
                
                        $empDeflevelById=$promotionService->readDeflevelById($request->getParameter('txtEmpId'));
                       
                        if($empDeflevelById){

                            $empDeflevel = $empDeflevelById;
                        }
                        
                        for ($i = 1; $i <= 10; $i++) {

                            $emp_def_col = "hie_code_" . $i;
                            $empDeflevel->$emp_def_col = null;
                            $Employee->$emp_def_col = null;
                        }
                        

                        $hieCode = $request->getParameter('txtNWorkStaion');

                        $division = $promotionService->readCompanyStructure($hieCode);
                        $defLevel = $division->getDefLevel();
                         while ($defLevel > 0 && $hieCode > 0) {

                            $hieCodeCol = "hie_code_" . $defLevel;
                            
                            $empDeflevel->$hieCodeCol = $hieCode;
                            $Employee->$hieCodeCol = $hieCode;
                            
                            $hieCode = $division->getParnt();
                            $division = $promotionService->readCompanyStructure($hieCode);

                            $defLevel = $defLevel - 1;
                        }
                        $empDeflevel->emp_number = $Employee->empNumber;
                        $empDeflevel->save();
                        $Employee->save();
                
                }
                $conn->commit();

                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__('Successfully Saved', $args, 'messages')));
            $this->redirect('promotion/listPromotion');
                
            } catch (Doctrine_Connection_Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/listPromotion');
            } catch (sfStopException $e) {

            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/listPromotion');
            }
        }
    }


    public function executeDeleteImage(sfWebRequest $request) {

        $id = $request->getParameter('id');
        $promotionSubDao=new promotionSubDao();
        
        try {
            $promotionSubDao->deleteImage($id);
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('promotion/updatePromotion?id=' . $request->getParameter('id'));
        }
        $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__('Successfully Saved', $args, 'messages')));
        $this->redirect('promotion/updatePromotion?id=' . $request->getParameter('id'));
    }



    public function executePromotionMethod(sfWebRequest $request) {
        try {
            $this->Culture = $this->getUser()->getCulture();

           
            $promotionSubService =new promotionSubService();
            $this->sorter = new ListSorter('PromotionMethod', 'promotion', $this->getUser(), array('r.prm_method_id', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array($this->getContext()->getI18N()->__('Select the field to search', $args, 'messages')));
                    $this->redirect('promotion/promotionMethod');
                }
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'r.prm_method_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $promotionSubService->getPromotionReasonList($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->listreasons = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }



    public function executeSavePromotionMethod(sfWebRequest $request) {
        $this->myCulture = $this->getUser()->getCulture();
        $promotionService = new promotionService();
        if ($request->isMethod('post')) {
            try {
                $PromotionMethod = new PromotionMethod();

                $PromotionMethod=$promotionService->getPromotionServiceObj($PromotionMethod,$request);

               
                $promotionService->savePromotionMethod($PromotionMethod);
                $this->lastid = $promotionService->getLastID();
            } catch (Doctrine_Connection_Exception $e) {

                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/promotionMethod');
            } catch (Exception $e) {

                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/promotionMethod');
            }
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__('Successfully Added', $args, 'messages')));
            $this->redirect('promotion/promotionMethod');
        }
    }

    public function executeUpdatePromotionMethod(sfWebRequest $request) {
        //Table Lock code is Open


        if (!strlen($request->getParameter('lock'))) {
            $this->lockMode = 0;
        } else {
            $this->lockMode = $request->getParameter('lock');
        }
        $transPid = $request->getParameter('id');
        if (isset($this->lockMode)) {
            if ($this->lockMode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_promotion_method', array($transPid), 1);

                if ($recordLocked) {
                    // Display page in edit mode
                    $this->lockMode = 1;
                } else {
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                    $this->lockMode = 0;
                }
            } else if ($this->lockMode == 0) {
                $conHandler = new ConcurrencyHandler();
                $recordLocked = $conHandler->resetTableLock('hs_hr_promotion_method', array($transPid), 1);
                $this->lockMode = 0;
            }
        }

        //Table lock code is closed

        $this->myCulture = $this->getUser()->getCulture();
        
        $promotionService = new promotionService();
        $PromotionMethod = new PromotionMethod();

        $PromotionMethod = $promotionService->readPromotionMethod($request->getParameter('id'));
        if (!$PromotionMethod) {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
            $this->redirect('promotion/promotionMethod');
        }
        $this->PromotionMethod = $PromotionMethod;
        if ($request->isMethod('post')) {
            try {
                $PromotionMethod=$promotionService->getPromotionServiceObj($PromotionMethod,$request);


                $promotionService->savePromotionMethod($PromotionMethod);
            } catch (Doctrine_Connection_Exception $e) {

                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/promotionMethod');
            } catch (Exception $e) {

                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/promotionMethod');
            }
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__('Successfully Updated', $args, 'messages')));
            $this->redirect('promotion/updatePromotionMethod?id=' . $PromotionMethod->getPrm_method_id() . '&lock=0');
        }
    }

    public function executeDeletePromotionMethod(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {

           
            $promotionSubService =new promotionSubService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_promotion_method', array($ids[$i]), 1);
                    if ($isRecordLocked) {

                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $promotionSubService->deleteReason($ids[$i]);
                        $conHandler->resetTableLock('hs_hr_promotion_method', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/promotionMethod');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/promotionMethod');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('promotion/promotionMethod');
    }

    public function setMessage($messageType, $message = array(), $persist=true) {
        $this->getUser()->setFlash('messageType', $messageType, $persist);
        $this->getUser()->setFlash('message', $message, $persist);
    }

    public function executeDeletePromotion(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
            $promotionSubService =new promotionSubService();
           
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_promotion', array($ids[$i]), 1);
                    if ($isRecordLocked) {

                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $promotionSubService->deleteAttach($ids[$i]);
                        $promotionSubService->deletePromotion($ids[$i]);
                        $conHandler->resetTableLock('hs_hr_promotion', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/listPromotion');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/listPromotion');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('promotion/listPromotion');
    }

    public function executeAjaxCall(sfWebRequest $request) {
        $this->culture = $this->getUser()->getCulture();
        $culture=$this->culture;
        $promotionDao = new promotionDao();
        $this->value = $request->getParameter('sendValue');
        $allpromotion = $promotionDao->readEmployee($this->value);
        
        if($culture=="en"){
           $this->value1 = $allpromotion->Grade->getGrade_name();
           $this->value3 = $allpromotion->jobTitle->getJobtit_name(); 
           $this->value5 = $allpromotion->employeeStatus->getEstat_name();
           $this->value7 = $allpromotion->subDivision->getTitle();
           $this->value11 = $allpromotion->EmpClass->class_name; 
           $this->value16 = $allpromotion->ServiceDetails->service_name;
           $this->value17 = $allpromotion->Level->level_name;
        
        }else if($culture=="si"){
            
           $this->value1 = $allpromotion->Grade->getGrade_name_si();
           $this->value3 = $allpromotion->jobTitle->getJobtit_name_si(); 
           $this->value5 = $allpromotion->employeeStatus->getEstat_name_si();
           $this->value7 = $allpromotion->subDivision->getTitle_si();
           $this->value11 = $allpromotion->EmpClass->class_name_si; 
           $this->value16 = $allpromotion->ServiceDetails->service_name_si;
           $this->value17 = $allpromotion->Level->level_name_si;
            
        }else if($culture=="ta"){
            
           $this->value1 = $allpromotion->Grade->getGrade_name_ta();
           $this->value3 = $allpromotion->jobTitle->getJobtit_name_ta(); 
           $this->value5 = $allpromotion->employeeStatus->getEstat_name_ta();
           $this->value7 = $allpromotion->subDivision->getTitle_ta();
           $this->value11 = $allpromotion->EmpClass->class_name_ta; 
           $this->value16 = $allpromotion->ServiceDetails->service_name_ta;
           $this->value17 = $allpromotion->Level->level_name_ta;
            
        }
           if($this->value1==null){
               $this->value1 = $allpromotion->Grade->getGrade_name();
           }
           if($this->value3==null){
           $this->value3 = $allpromotion->jobTitle->getJobtit_name(); 
           }
           if($this->value5==null){
           $this->value5 = $allpromotion->employeeStatus->getEstat_name();
           }
           if($this->value7==null){
           $this->value7 = $allpromotion->subDivision->getTitle();
           }
           if($this->value11==null){
           $this->value11 = $allpromotion->EmpClass->class_name; 
           }
           if($this->value16==null){
           $this->value16 = $allpromotion->ServiceDetails->service_name;
           }
           if($this->value17==null){
           $this->value17 = $allpromotion->Level->level_name;
           }
        
        

        $this->value8 = $allpromotion->getWork_station();  
        $this->value4 = $allpromotion->getJob_title_code();
        $this->value2 = $allpromotion->getGrade_code();
        $this->value6 = $allpromotion->getEmp_status();
        $this->value9 = $allpromotion->getService_code();
        $this->value10 = $allpromotion->emp_nic_no;
        $this->value12 = $allpromotion->grade_code;
        $salaryslot=$promotionDao->getGradeSlotLoadID($allpromotion->slt_scale_year,$allpromotion->grade_code);
        $this->value13 = $salaryslot->slt_scale_year." -> ".$salaryslot->emp_basic_salary;
        $this->value14 = $allpromotion->emp_salary_inc_date;
        $this->value15 = $allpromotion->work_station;
        $this->value18 = $allpromotion->employeeId;
        


    }

    /* checklist */

    public function executePromotioncklist(sfWebRequest $request) {

        try {
            $this->Culture = $this->getUser()->getCulture();

            
            $promotionSubService =new promotionSubService();

            $this->sorter = new ListSorter('promotionChecklist', 'promotion', $this->getUser(), array('r.prm_checklist_id', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array($this->getContext()->getI18N()->__('Select the field to search', $args, 'messages')));
                    $this->redirect('promotion/promotioncklist');
                }
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'r.prm_checklist_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $promotionSubService->getPromotionckList($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->listreasons = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeSavePromotioncklist(sfWebRequest $request) {
        $this->myCulture = $this->getUser()->getCulture();
        $promotionService = new promotionService();

        if ($request->isMethod('post')) {
            try {

                $PromotionCkecklist = new PromotionCkecklist();
                $promotionService->savePromotioncklist($PromotionCkecklist,$request);
                $this->lastid = $promotionService->getLastID();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/promotioncklist');
            } catch (Exception $e) {

                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/promotioncklist');
            }

            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__('Successfully Added', $args, 'messages')));
            $this->redirect('promotion/promotioncklist?id=' . $this->lastid[0]['MAX']);
        }
    }

    public function executeUpdatePromotioncklist(sfWebRequest $request) {
        //Table Lock code is Open


        if (!strlen($request->getParameter('lock'))) {
            $this->lockMode = 0;
        } else {
            $this->lockMode = $request->getParameter('lock');
        }
        $transPid = $request->getParameter('id');
        if (isset($this->lockMode)) {
            if ($this->lockMode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_promotion_ckecklist', array($transPid), 1);

                if ($recordLocked) {
                    // Display page in edit mode
                    $this->lockMode = 1;
                } else {
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                    $this->lockMode = 0;
                }
            } else if ($this->lockMode == 0) {
                $conHandler = new ConcurrencyHandler();
                $recordLocked = $conHandler->resetTableLock('hs_hr_promotion_ckecklist', array($transPid), 1);
                $this->lockMode = 0;
            }
        }

        //Table lock code is closed
        $this->myCulture = $this->getUser()->getCulture();
        $promotionDao = new promotionDao();
        
        $PromotionCkecklist = new PromotionCkecklist();

        $PromotionCkecklist = $promotionDao->readPromotioncklist($request->getParameter('id'));
        if (!$PromotionCkecklist) {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
            $this->redirect('promotion/promotioncklist');
        }

        $this->PromotionCkecklist = $PromotionCkecklist;
        if ($request->isMethod('post')) {
            try {
             
                $promotionDao->savePromotioncklist($PromotionCkecklist,$request);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/promotioncklist');
            } catch (Exception $e) {

                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/promotioncklist');
            }
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__('Successfully Updated', $args, 'messages')));
            $this->redirect('promotion/updatePromotioncklist?id=' . $PromotionCkecklist->getPrm_checklist_id() . '&lock=0');
        }
    }

    public function executeDeletePromotioncklist(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
            $promotionSubDao = new promotionSubDao();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_promotion_ckecklist', array($ids[$i]), 1);
                    if ($isRecordLocked) {

                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $promotionSubDao->deleteReasoncklist($ids[$i]);
                        $conHandler->resetTableLock('hs_hr_promotion_ckecklist', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/promotioncklist');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/promotioncklist');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('promotion/promotioncklist');
    }

    public function executeImagepop(sfWebRequest $request) {

        $promoDao = new promotionDao();
        $attachment = $promoDao->getAttachdetails($request->getParameter('id'));
        $outname = stripslashes($attachment[0]['prm_attach_attachment']);
        $type = stripslashes($attachment[0]['prm_attach_type']);
        $name = stripslashes($attachment[0]['prm_attach_filename']);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header('Content-Description: File Transfer');           
        header("Content-type:" . $type);
        header('Content-disposition: attachment; filename=' . $name);
        echo($outname);
        exit;
    }

    public function executeImagepop1(sfWebRequest $request) {

        $promoDao = new promotionDao();
        $attachment = $promoDao->getAttachdetails1($request->getParameter('id'));
        $outname = stripslashes($attachment[0]['prm_cnf_attach_attachment']);
        $type = stripslashes($attachment[0]['prm_cnf_attach_type']);
        $name = stripslashes($attachment[0]['prm_attach_filename']);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header('Content-Description: File Transfer'); 
        header("Content-type:" . $type);
        header('Content-disposition: attachment; filename=' . $name);
        echo($outname);
        exit;
    }

    public function executeDeletepop(sfWebRequest $request) {

        $promotionSubDao = new promotionSubDao();
         $promotionSubDao->deleteAttach($request->getParameter('id'));
        $this->redirect('promotion/savePromotion?update=yes&id=' . $request->getParameter('id') . '&con=1');
    }

    public function executeDeletepop1(sfWebRequest $request) {

        $promotionSubDao = new promotionSubDao();
        $promotionSubDao = $promotionSubDao->deleteAttach1($request->getParameter('id'));
        $this->redirect('promotion/updatePromotion?id=' . $request->getParameter('id') . '&con=1');
    }

    public function executeProbationlist(sfWebRequest $request) {

        try {
            $this->Culture = $this->getUser()->getCulture();
            $promotionSubService =new promotionSubService();
            

            $this->sorter = new ListSorter('probationlist', 'promotion', $this->getUser(), array('r.emp_number', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array($this->getContext()->getI18N()->__('Select the field to search', $args, 'messages')));
                    $this->redirect('promotion/promotioncklist');
                }
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'r.emp_number' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $promotionSubService->getProbationlist($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->listreasons = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeChecklist(sfWebRequest $request) {
        if (!strlen($request->getParameter('lock'))) {
            $this->lockMode = 0;
        } else {
            $this->lockMode = $request->getParameter('lock');
        }
        $this->kk = $request->getParameter('id');
        $PrmPid = $request->getParameter('id');

        if (isset($this->lockMode)) {
            if ($this->lockMode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_ckecklist_detail', array($PrmPid), 1);

                if ($recordLocked) {
                    // Display page in edit mode
                    $this->lockMode = 1;
                } else {
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                    $this->lockMode = 0;
                }
            } else if ($this->lockMode == 0) {
                $conHandler = new ConcurrencyHandler();
                $recordLocked = $conHandler->resetTableLock('hs_hr_ckecklist_detail', array($PrmPid), 1);
                $this->lockMode = 0;
            }
        }

        $this->culture = $this->getUser()->getCulture();
        $promotionDao = new promotionDao();
        $this->employee=$promotionDao->getEmployee($PrmPid);
        $this->PromotionCkecklist = $promotionDao->getPckList();
        $this->PromotionCkecklistmax = $promotionDao->getPromotionckListmax();
        $this->PromotionCkeckdetals = $promotionDao->cklistetails($request->getParameter('id'));
        $this->PromotionCkeckDatedetals = $promotionDao->cklistetailsDate($request->getParameter('id'));
        $this->PromotionCkeckComment = $promotionDao->PromotionCkeckComment($request->getParameter('id'));

        if ($request->isMethod('post')) {//die(print_r($_POST));
            try {
                $max = $request->getParameter('cklmax');
                
                //for ($i = 0; $i <  $max; $i++) {
                foreach($this->PromotionCkecklist as $row){
                    if($request->getParameter('ck'. $row['prm_checklist_id'])!=null){
                    $j = $row['prm_checklist_id'];
                    //$promotionDao->ckdel($request->getParameter('id'), $j);
                    
                    if($j!=null){
                    if (strlen($request->getParameter('ck'. $row['prm_checklist_id']))) {
                        
                        $promotionckdetails=$promotionDao->getPromortionChecklistByID($j,$PrmPid);

                        if($promotionckdetails->prm_checklist_id==null){
                        $promotionckdetails = new PromotionChecklistDetail();
                        $promotionckdetails->setEmp_number($PrmPid);
                        $promotionckdetails->setPrm_checklist_id($j);
                        if(($request->getParameter('txtComepDate_'. $row['prm_checklist_id'])!=null)){   
                            //$promotionckdetails->setPrm_value('1');
                            $promotionckdetails->setPrm_complete_date($request->getParameter('txtComepDate_' . $row['prm_checklist_id']));
                        }else{
                            $promotionckdetails->setPrm_complete_date(null);
                          //$promotionckdetails->setPrm_value('0');  
                        }
                        $promotionckdetails->setPrm_value('1');
                        
                        $promotionckdetails->setPrm_comment(trim($request->getParameter('txtComment_' . $row['prm_checklist_id'])));
                        $promotionckdetails->setPrm_ovr_comment(trim($request->getParameter('ovrcomment')));
                        $promotionDao->savecklistdetails($promotionckdetails);
                        
                        }else{
                        
                        
                        if(($request->getParameter('txtComepDate_'. $row['prm_checklist_id'])!=null)){   
                            //$promotionckdetails->setPrm_value('1');
                            $promotionckdetails->setPrm_complete_date($request->getParameter('txtComepDate_' . $row['prm_checklist_id']));
                        }else{
                          //$promotionckdetails->setPrm_value('0');
                          $promotionckdetails->setPrm_complete_date(null);
                        }
                        
                        $promotionckdetails->setPrm_value('1');
                        $promotionckdetails->setPrm_comment(trim($request->getParameter('txtComment_' . $row['prm_checklist_id'])));
                        $promotionckdetails->setPrm_ovr_comment(trim($request->getParameter('ovrcomment')));
                        $promotionDao->savecklistdetails($promotionckdetails);
                        
                    
                 }} } }else{
                     $j = $row['prm_checklist_id'];
                    //$promotionDao->ckdel($request->getParameter('id'), $j);
                    
                    if($j!=null){
                        $promotionckdetails=$promotionDao->getPromortionChecklistByID($j,$PrmPid);
                        if($promotionckdetails->prm_checklist_id!=null){
                          $promotionckdetails->setPrm_value('0');  
                          $promotionckdetails->setPrm_complete_date(null);
                          $promotionckdetails->setPrm_comment(null);
                        
                        $promotionDao->savecklistdetails($promotionckdetails);
                    }
                    }
                     
                     } //}
                 }
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/probationlist');    
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/probationlist');
            }
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__('Successfully Updated', $args, 'messages')));
            $this->redirect('promotion/checklist?id=' . $PrmPid . '&lock=0');
        }
    }

    public function executeError(sfWebRequest $request) {

        $this->redirect('default/error');
    }
    
        public function executeLoadGradeSlot(sfWebRequest $request) {

        $this->Culture = $this->getUser()->getCulture();
        $jobDao=new JobDao();

        $id = $request->getParameter('id');
        $Slot = $jobDao->getGradeSlotByID($id);
        $arr = Array();
        foreach ($Slot as $row) {

            $arr[]=$row->grade_code."|".$row->slt_scale_year."|".$row->slt_amount."|".$row->emp_basic_salary."|".$row->slt_id;
        }

        echo json_encode($arr);
        die;
    }
    
    public function executeDisplayEmpHirache(sfWebRequest $request) {

        $wst = $request->getParameter('wst');
        $companyService = new CompanyService();
        $CompanyDao = new CompanyDao();
        $userCulture = $this->getUser()->getCulture();

        $ActhieCode = $request->getParameter('wst');
        $name = array();
        $levelname = array();
        $Actdivision = $companyService->readCompanyStructure($ActhieCode);
        $ActdefLevel = $Actdivision->getDefLevel();
        while ($ActdefLevel > 0 && $ActhieCode > 0) {

            $ActhieCode = $Actdivision->getParnt();
            if ($userCulture == "en") {
                $name[] = $Actdivision['title'];
            } else {
                $Title = 'title_' . $userCulture;
                if ($Actdivision[$Title] == "") {
                    $name[] = $Actdivision['title'];
                } else {
                    $name[] = $Actdivision[$Title];
                }
            }
            $Levelofdivition = $CompanyDao->getDefLevelDetals($Actdivision['def_level']);
            if ($userCulture == "en") {
                $levelname[] = $Levelofdivition[0]->getDef_name();
            } else {
                $deflevel = 'getDef_name_' . $userCulture;
                if ($Levelofdivition[0]->$deflevel() == "") {
                    $levelname[] = $Levelofdivition[0]->getDef_name();
                } else {
                    $levelname[] = $Levelofdivition[0]->$deflevel();
                }
            }


            $Actdivision = $companyService->readCompanyStructure($ActhieCode);

            $ActdefLevel = $ActdefLevel - 1;
        }
        echo json_encode(array("name1" => $name[0], "name2" => $name[1], "name3" => $name[2], "name4" => $name[3], "name5" => $name[4], "name6" => $name[5], "name7" => $name[6], "name8" => $name[7], "name9" => $name[8], "name10" => $name[9], "nameLevel1" => $levelname[0], "nameLevel2" => $levelname[1], "nameLevel3" => $levelname[2], "nameLevel4" => $levelname[3], "nameLevel5" => $levelname[4], "nameLevel6" => $levelname[5], "nameLevel7" => $levelname[6], "nameLevel8" => $levelname[7], "nameLevel9" => $levelname[8], "nameLevel10" => $levelname[9]));
        die;
    }
    
     public function executeOtherInstitution(sfWebRequest $request){
      try {
            $this->Culture = $this->getUser()->getCulture();
            
$promotionSubService =new promotionSubService();
            $this->sorter = new ListSorter('OtherInstitution', 'promotion', $this->getUser(), array('o.oth_inst_id', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('promotion/OtherInstitution');
                }
                $this->var = 1;
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'o.oth_inst_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $promotionSubService->searchOtherInstitution($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->InstituteList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
      
  } 
  
  public function executeUpdateOtherInstitution(sfWebRequest $request) {
        $PromotionService = new promotionService(); 
        $this->myCulture = $this->getUser()->getCulture();
        //Table Lock code is Open
        if($request->getParameter('id')){  
        $encrypt = new EncryptionHandler();
        if (!strlen($request->getParameter('lock'))) {
            $this->lockMode = 0;
        } else {
            $this->lockMode = $request->getParameter('lock');
        }
        $VTID = $encrypt->decrypt($request->getParameter('id'));
        if (isset($this->lockMode)) {
            if ($this->lockMode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_other_institute', array($VTID), 1);

                if ($recordLocked) {
                    // Display page in edit mode
                    $this->lockMode = 1;
                } else {
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                    $this->lockMode = 0;
                }
            } else if ($this->lockMode == 0) {
                $conHandler = new ConcurrencyHandler();
                $recordLocked = $conHandler->resetTableLock('hs_hr_other_institute', array($VTID), 1);
                $this->lockMode = 0;
            }
        }

        //Table lock code is closed
        

        $OtherInstitute = $PromotionService->readOtherInstitution($encrypt->decrypt($request->getParameter('id')));
        if (!$OtherInstitute) {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
            $this->redirect('promotion/OtherInstitution');
        }
        }else{
           $OtherInstitute = new OtherInstitute();
           $this->lockMode = 1;
        }
        $this->OtherInstitute= $OtherInstitute;

        if ($request->isMethod('post')) {
            //die(print_r($OtherInstitute));
            $Employee=$PromotionService->getEmployee($request->getParameter('txtEmpId'));
            (strlen($request->getParameter('txtEmpId')  ? $OtherInstitute->setEmp_number(trim($request->getParameter('txtEmpId'))) : $OtherInstitute->setEmp_number(null))); 
            (strlen($request->getParameter('txtInstitute')  ? $OtherInstitute->setOth_institute_name(trim($request->getParameter('txtInstitute'))) : $OtherInstitute->setOth_institute_name(null)));
            (strlen($request->getParameter('txtReleasedLocation')  ? $OtherInstitute->setOth_release_location(trim($request->getParameter('txtReleasedLocation'))) : $OtherInstitute->setOth_release_location(null)));
            (strlen($request->getParameter('txtReleasedPeriodFrom')  ? $OtherInstitute->setOth_release_from(trim(LocaleUtil::getInstance()->convertToStandardDateFormat($request->getParameter('txtReleasedPeriodFrom')))) : $OtherInstitute->setOth_release_from(null)));
            (strlen($request->getParameter('txtReleasedPeriodTo')  ? $OtherInstitute->setOth_release_to(trim(LocaleUtil::getInstance()->convertToStandardDateFormat($request->getParameter('txtReleasedPeriodTo')))) : $OtherInstitute->setOth_release_to(null)));
            (strlen($request->getParameter('cmbPayrollActive') ? $OtherInstitute->setOth_payroll_active_flg(1) : $OtherInstitute->setOth_payroll_active_flg(0)));
            (strlen($request->getParameter('txtReason')  ? $OtherInstitute->setOth_reason(trim($request->getParameter('txtReason'))) : $OtherInstitute->setOth_reason(null)));
            
            (strlen($request->getParameter('cmbPayrollActive') ? $Employee->setEmp_active_pr_flg(1) : $Employee->setEmp_active_pr_flg(0)));
            
            
            try {
                
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $PromotionService->saveOtherInstitution($OtherInstitute);
                $PromotionService->saveEmployee($Employee);
                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $conn->rollback();
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/UpdateOtherInstitution?id=' . $encrypt->encrypt($OtherInstitute->oth_inst_id ) . '&lock=0');
            } catch (Exception $e) {
                $conn->rollback();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/UpdateOtherInstitution?id=' . $encrypt->encrypt($OtherInstitute->oth_inst_id ) . '&lock=0');
            }
            if($OtherInstitute->oth_inst_id){
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
            $this->redirect('promotion/UpdateOtherInstitution?id=' . $encrypt->encrypt($OtherInstitute->oth_inst_id ) . '&lock=0');
            }else{
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Saved", $args, 'messages')));
            $this->redirect('promotion/OtherInstitution');
                
            }
            
        }
    }
    
public function executeDeleteOtherInstitution(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
            
            $promotionSubService =new promotionSubService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_other_institute', array($ids[$i]), 1);
                    if ($isRecordLocked) {

                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $promotionSubService->deleteOtherInstitution($ids[$i]);
                        $conHandler->resetTableLock('hs_hr_other_institute', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/OtherInstitution');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('promotion/OtherInstitution');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('promotion/OtherInstitution');
    }

    
        public function executeHistoryPromotion(sfWebRequest $request) {
        try { //die(print_r($request));
            $this->culture = $this->getUser()->getCulture();
            $this->var = 0;
            $promotionDao = new promotionDao();
            $this->pDao = $promotionDao;
            $promotionSubService =new promotionSubService();
           

            $this->sorter = new ListSorter('HistoryPromotion', 'promotion', $this->getUser(), array('p.prm_id', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array($this->getContext()->getI18N()->__('Select the field to search', $args, 'messages')));
                    $this->redirect('promotion/HistoryPromotion');
                }
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');
            $this->EmpNo = ($request->getParameter('txtEmpId') == null) ? $request->getParameter('empno') : $request->getParameter('txtEmpId');
            $this->EmpName = ($request->getParameter('txtEmployeeName') == null) ? $request->getParameter('empname') : $request->getParameter('txtEmployeeName');
//die(print_r($this->EmpNo));
            $this->sort = ($request->getParameter('sort') == '') ? 'p.prm_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $promotionSubService->getHistoryPromotion($this->searchMode, $this->searchValue, $this->culture, $this->sort, $this->order, $request->getParameter('page'),$this->EmpNo, $this->EmpName);
            $this->listPromotion = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');

        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }
    
    public function executeDateValidation(sfWebRequest $request) {


            $promotionSubDao = new promotionSubDao();
            $employee = $promotionSubDao->getJoinedDate($request->getParameter('empId'));
            $this->employee = $employee;
            $joindate = $employee->getEmp_com_date();
            $jointimest = strtotime(date($joindate));
            $PRMtimest = strtotime(LocaleUtil::getInstance()->convertToStandardDateFormat($request->getParameter('sendValue')));

            $lasteffectiveDate = $promotionSubDao->getLastEffectiveDate($request->getParameter('empId'));
            $lasteffectivetimestamp = strtotime($lasteffectiveDate[0]['MAX']);

            if ($PRMtimest < $lasteffectivetimestamp) {
                $message = "error";

            } elseif ($PRMtimest < $jointimest) {

                $message = "error";
            }

            else {
                $message = "ok";
            }
            
            echo json_encode(array("message"=>$message));
            die;
    }  
    
    
    
    public function executeEBExam(sfWebRequest $request){
        $promotionSubDao = new promotionSubDao();
        $Culture = $this->getUser()->getCulture();

        $empid = $request->getParameter('empid');
        $serviceId = $request->getParameter('service');
        $gradeId = $request->getParameter('grade');

        $empEbExams=$promotionSubDao->getEBExam($empid,$serviceId,$gradeId);


            $this->childDiv.="<div id='master' style='width:280px; display:inline-block;'>";
            $this->childDiv.="<label id='child'  style='width:100px; font-weight: bold'>" .$this->getContext()->getI18N()->__('EB Exam', $args, 'messages'). " </label>";
            $this->childDiv.="<label id='child'  style='width:100px; font-weight: bold'>" .$this->getContext()->getI18N()->__('Complete Date', $args, 'messages'). " </label>";
            $this->childDiv.="</div>";
            $this->childDiv.="<br/>";

        foreach($empEbExams as $exam){
            
            //if($exam['EBExam']['service_code']==$serviceId && $exam['EBExam']['grade_code']==$gradeId ){
            if($Culture=="en"){ 
                $name=$exam['EBExam']['ebexam_name'];                
                }else{ 
                $name=$exam['EBExam']['ebexam_name_'.$Culture]; 
                if($name==null){
                    $name=$exam['EBExam']['ebexam_name']; 
                }
            }
            $this->childDiv.="<div id='master' style='width:280px; display:inline-block;'>";
            $this->childDiv.="<label id='child'  style='width:100px;'>" .$name . " </label>";
            $this->childDiv.="<label id='child'  style='width:100px;'>" . $exam['emp_ebexam_completedate'] . " </label>";
            $this->childDiv.="</div>";
            $this->childDiv.="<br/>";
            //}
              
        }

        


echo json_encode($this->childDiv);

die;        
    }
    
        

    

}