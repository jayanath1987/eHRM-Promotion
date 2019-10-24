<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.simplemodal.js') ?>"></script>
<div id="dialog" title="<?php echo __("EB Exams"); ?>">
    <div id="test">


    </div>
</div>
<div class="outerbox" >
    <div class="maincontent">

        <div class="mainHeading" ><h2><?php echo __("Promotion  History") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="">
                        <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode" style="font-weight: bold; color:#000000; width:180px;"><?php echo __("Employee Name") ?> <span class="required">*</span>
                </label>
            </div>
            <div class="centerCol"  style="width:500px">
<!--                <input type="text" class="formInputText" name="txtEmployeeName"  id="txtEmployee" value="<?php echo $EmpName; ?>" readonly="readonly"  style="color: #222222; width:210px;"/>-->&nbsp;&nbsp;
<!--                <label id="empsearchnames" ></label> -->
                <input type="hidden" name="txtEmpId" id="txtEmpId" value="<?php echo $EmpNo; ?>"/>
                <?php if($update!="Update"){ ?>
                <input class="button" style="margin-top: 7px;"type="button" value="..." id="empRepPopBtn" name="empRepPopBtn" <?php //echo $disabled; ?> />
                <?php } ?>
 </div>
                <br class="clear"/> 
            
            <input type="hidden" name="mode" value="search"/>
            <div class="searchbox">
                <label for="searchMode"><?php echo __("Search By") ?></label>
                <select name="searchMode" id="searchMode">
                    <option value="all"><?php echo __("--Select--") ?></option>

                    <option value="prm_effective_date" <?php
                            if ($searchMode == 'prm_effective_date') {
                                echo "selected";
                            } ?>><?php echo __("EffDate") ?></option>
                    <option value="prm_method_comment_" <?php
                            if ($searchMode == 'prm_method_comment_') {
                                echo "selected";
                            }
        ?>><?php echo __("PrmMethod") ?></option>
<!--                    <option value="emp_display_name_" <?php
                         /*   if ($searchMode == 'emp_display_name_') {
                                echo "selected";
                            } 
        ?>><?php echo __("Employer Name")*/ ?></option>-->

                </select>

                <label for="searchValue"><?php echo __("Search For:") ?></label>
                <input type="text" size="20" name="searchValue" id="searchValue" value="<?php echo $searchValue ?>" />
                <input type="submit" class="plainbtn"
                       value="<?php echo __("Search") ?>" />
                <input type="reset" class="plainbtn" id="resetBtn"
                       value="<?php echo __("Reset") ?>" />
                <br class="clear"/>
            </div>
        </form>
        <div class="actionbar">
<!--            <div class="actionbuttons">

                <input type="button" class="plainbtn" id="buttonAdd"
                       value="<?php echo __("Add") ?>" />


                <input type="button" class="plainbtn" id="buttonRemove"
                       value="<?php echo __("Delete") ?>" />

            </div>-->
            <div class="noresultsbar"></div>
            <div class="pagingbar"><?php echo is_object($pglay) ? $pglay->display() : ''; ?>  </div>
            <br class="clear" />
        </div>
        <br class="clear" />
        <form name="standardView" id="standardView" method="post" action="<?php echo url_for('promotion/DeletePromotion') ?>">
            <input type="hidden" name="mode" id="mode" value=""/>
            <table cellpadding="0" cellspacing="0" class="data-table">
                <thead>
                    <tr>
                        <td width="50">

<!--                            <input type="checkbox" class="checkbox" name="allCheck" value="" id="allCheck" />-->

                        </td>


                        <td scope="col">
                            <?php
                            if ($culture == 'en') {
                                $btname = 'e.emp_display_name';
                            } else {
                                $btname = 'e.emp_display_name_' . $culture;
                            }
                            ?>
                            <?php echo __('Employee Name'); ?>
                        </td>
                        <td scope="col">
                            <?php
                            if ($culture == 'en') {
                                $btname = 's.service_name';
                            } else {
                                $btname = 's.service_name_' . $culture;
                            } ?>
                            <?php echo __('Division'); ?>
                        </td>
                        <td scope="col">
                            <?php
                            if ($culture == 'en') {
                                $btname = 'j.jobtit_name';
                            } else {
                                $btname = 'j.jobtit_name_' . $culture;
                            } ?>
                            <?php echo __('Designation'); ?>
                        </td>
                        <td scope="col">                            
                            <?php
                            if ($culture == 'en') {
                                $btname = 'emp.name';
                            } else {
                                $btname = 'emp.estat_name_' . $culture;
                            }
                            ?>
                            <?php echo __('Emp.Type'); ?>
                        </td>
                        <td scope="col">
                            <?php echo __('Efc.Date'); ?>
                        </td>

                        <td scope="col">
                            <?php
                            if ($culture == 'en') {
                                $btname = 'pm.prm_method_comment_en';
                            } else {
                                $btname = 'pm.prm_method_comment_' . $culture;
                            }
                            ?>
                            <?php echo __('Prm.Method'); ?>
                        </td>
                        <td scope="col" width="50">
                            <?php echo __('P.Letter') ?>
                        </td>
                        <td scope="col" width="50">
                            <?php echo __('EB Exam') ?>
                        </td>
                        <td scope="col"  >
                            <?php echo __('Comment') ?>
                        </td>
                        <td scope="col">
                        </td>

                    </tr>
                </thead>

                <tbody>
                    <?php
                            $row = 0;
                            foreach ($listPromotion as $promotion) {
                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                $row = $row + 1;
                    ?>
                                <tr class="<?php echo $cssClass ?>">
                                    <td >
<!--                                        <input type='checkbox' class='checkbox innercheckbox' name='chkLocID[]' id="chkLoc" value='<?php //echo $promotion->getPrm_id() ?>' />-->
                                    </td>


                            
                            <td class="" width="90">
<!--                                <a href="<?php //echo url_for('promotion/savePromotion?update=yes&id=' . $promotion->prm_id) ?>">-->
                            <?php
                                if ($culture == 'en') {
                                    $dd = $promotion->Employee->getEmp_display_name();
                                    $rest = substr($promotion->Employee->getEmp_display_name(), 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest ?>..<span title="<?php echo $dd ?>">...</span><?php
                                    } else {
                                        echo $rest;
                                    }
                                } else {
                                    $abc = 'getEmp_display_name_' . $culture;
                                    $dd = $promotion->Employee->$abc();
                                    $rest = substr($promotion->Employee->$abc(), 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest
                            ?>.<span title="<?php echo $dd ?>">...</span><?php
                                    } else {
                                        echo $rest;
                                    }
                                    if ($promotion->Employee->$abc() == null) {
                                        $dd = $promotion->Employee->getEmp_display_name();
                                        $rest = substr($promotion->Employee->getEmp_display_name(), 0, 100);
                                        if (strlen($dd) > 100) {
                                            echo $rest ?>.<span title="<?php echo $dd ?>">...</span><?php
                                        } else {
                                            echo $rest;
                                        }
                                    }
                                }
                                ?>
<!--                             </a>-->
                            </td>
                            <td class="" width="90">
                            <?php
//                    
                            if ($culture == 'en') {
                                    $dd = $promotion->CompanyStructure->title;
                                    $rest = substr($promotion->CompanyStructure->title, 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest ?>.<span title="<?php echo $dd ?>">...</span><?php
                                    } else {
                                        echo $rest;
                                    }
                                } else {
                                    $abc = 'title_' . $culture;
                                    $dd = $promotion->CompanyStructure->$abc;
                                    $rest = substr($promotion->CompanyStructure->$abc, 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest ?>.<span title="<?php echo $dd ?>">...</span><?php
                                    } else {
                                        echo $rest;
                                    }
                                    if ($promotion->CompanyStructure->$abc == null) {
                                        $dd = $promotion->CompanyStructure->title;
                                        $rest = substr($promotion->CompanyStructure->title, 0, 100);
                                        if (strlen($dd) > 100) {
                                            echo $rest ?>.<span title="<?php echo $dd ?>">...</span> <?php
                                        } else {
                                            echo $rest;
                                        }
                                    }
                                } 
                                ?>
                            </td>
                            <td class="" width="90" >
                            <?php
                                if ($culture == 'en') {
                                    $dd = $promotion->JobTitle->getJobtit_name();
                                    $rest = substr($promotion->JobTitle->getJobtit_name(), 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest ?>.<span title="<?php echo $dd ?>">...</span><?php
                                    } else {
                                        echo $rest;
                                    }
                                } else {
                                    $abc = 'getJobtit_name_' . $culture;
                                    $dd = $promotion->JobTitle->$abc();
                                    $rest = substr($promotion->JobTitle->$abc(), 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest ?>..<span title="<?php echo $dd ?>">...</span><?php
                                    } else {
                                        echo $rest;
                                    }
                                    if ($promotion->JobTitle->$abc() == null) {
                                        $dd = $promotion->JobTitle->getJobtit_name();
                                        $rest = substr($promotion->JobTitle->getJobtit_name(), 0, 100);
                                        if (strlen($dd) > 100) {
                                            echo $rest ?>..<span title="<?php echo $dd ?>">...</span><?php
                                        } else {
                                            echo $rest;
                                        }
                                    }
                                }
                            ?>
                            </td>
                            <td class="" width="90">
                            <?php
                                if ($culture == 'en') {
                                    $dd = $promotion->EmployeeStatus->getEstat_name();
                                    $rest = substr($promotion->EmployeeStatus->getEstat_name(), 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest ?>..<span title="<?php echo $dd ?>">...</span><?php
                                    } else {
                                        echo $rest;
                                    }
                                } else {
                                    $abc = 'getEstat_name_' . $culture;
                                    $dd = $promotion->EmployeeStatus->$abc();
                                    $rest = substr($promotion->EmployeeStatus->$abc(), 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest
                            ?>.<span title="<?php echo $dd ?>">...</span><?php
                                    } else {
                                        echo $rest;
                                    }
                                    if ($promotion->EmployeeStatus->$abc() == null) {
                                        $dd = $promotion->EmployeeStatus->getEstat_name();
                                        $rest = substr($promotion->EmployeeStatus->getEstat_name(), 0, 100);
                                        if (strlen($dd) > 100) {
                                            echo $rest ?>.<span title="<?php echo $dd ?>">...</span><?php
                                        } else {
                                            echo $rest;
                                        }
                                    }
                                }
                            ?>
                            </td>
                            <td class="" width="90">
                            <?php echo LocaleUtil::getInstance()->formatDate($promotion->getPrm_effective_date()); ?>


                            </td>

                            <td class="" width="90">
                            <?php
                                if ($culture == 'en') {
                                    $dd = $promotion->PromotionMethod->getPrm_method_comment_en();
                                    $rest = substr($promotion->PromotionMethod->getPrm_method_comment_en(), 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest ?>.<span title="<?php echo $dd ?>">...</span><?php
                                    } else {
                                        echo $rest;
                                    }
                                } else {
                                    $abc = 'getPrm_method_comment_' . $culture;
                                    $dd = $promotion->PromotionMethod->$abc();
                                    $rest = substr($promotion->PromotionMethod->$abc(), 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest ?>..<span title="<?php echo $dd ?>">...</span><?php
                                    } else {
                                        echo $rest;
                                    }
                                    if ($promotion->PromotionMethod->$abc() == null) {
                                        $dd = $promotion->PromotionMethod->getPrm_method_comment_en();
                                        $rest = substr($promotion->PromotionMethod->getPrm_method_comment_en(), 0, 100);
                                        if (strlen($dd) > 100) {
                                            echo $rest
                            ?>..<span title="<?php echo $dd ?>">...</span><?php
                                        } else {
                                            echo $rest;
                                        }
                                    }
                                } ?>
                            </td>
                            <td class="">
                                <a href="#" onclick="popuimage(link='<?php echo url_for('promotion/imagepop?id='); ?><?php echo $promotion->getPrm_id() ?>')"><?php
                                $kk = $pDao->readattach($promotion->getPrm_id());
                                foreach ($kk as $rowa) {
                                    if ($rowa['count'] == 1) {
                                        echo __("View");
                                    }
                                }
                            ?></a>

                        </td>
                        <td class="">
                                <a href="#" onclick="setEbExam('<?php echo $promotion->emp_number ?>','<?php echo $promotion->service_code ?>','<?php echo $promotion->grade_code ?>')"><?php
                                
                                        echo __("View");
                                   
                               
                            ?></a>

                        </td>
                        <td class="" >
                            <?php
                                $dd = $promotion->getPrm_comment();
                                $rest = substr($promotion->getPrm_comment(), 0, 100);
                                if (strlen($dd) > 100) {
                                    echo $rest
                            ?>.<span title="<?php echo $dd ?>">...</span><?php
                                } else {
                                    echo $rest;
                                }
                            ?>
                            </td>

                        </tr>
                    <?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            myArr=new Array();
            jQuery("#dialog").dialog({

                bgiframe: true, autoOpen: false, position: 'center', minWidth:300, maxWidth:300, modal: true
            });
            function setEbExam(empid,service,grade){
                
                $.ajax({
                             type: "POST",
                             async:false,
                             url: "<?php echo url_for('promotion/EBExam') ?>",
                             data: { empid : empid ,service : service, grade :grade },
                             dataType: "json",
                             success: function(data){ 
                                 $("#test").empty();
                                 $("#test").append(data);}
                         });
                
                
                //$("#test").append(empid+service+grade);
                jQuery('#dialog').dialog('open');
                return false;
            }
            
            function disableAnchor(obj, disable){
                if(disable){
                    var href = obj.getAttribute("href");
                    if(href && href != "" && href != null){
                        obj.setAttribute('href_bak', href);
                    }
                    obj.removeAttribute('href');
                    obj.style.color="gray";
                }
                else{
                    obj.setAttribute('href', obj.attributes
                    ['href_bak'].nodeValue);
                    obj.style.color="blue";
                }
            }
            
              function SelectEmployee(data){

                myArr=new Array();
                //myArr1=new Array();
                //if(isNaN(data.split('|'))){
                
                $.each(data.split('|'),function(key, value1){ 
                    if(!isNaN(value1)){
                addtoGrid(value1);
                    }
//                    if(key==1){
//                $("#empsearchnames").text(value1);
//                    }


                });
                
 //$("#frmSearchBox").submit();
    $("#txtEmpId").val(myArr);
                search();


            }
            function search(){
                 //$("#txtEmpId").val(myArr);                        
                 $("#frmSearchBox").submit();
                 
            }
            function addtoGrid(empid){
                

                         var arraycp=new Array();

                         var arraycp = $.merge([], myArr);

                         var items= new Array();
                         for(i=0;i<empid.length;i++){

                             items[i]=empid[i];
                         }




                         var u=1;

                         $.each(items,function(key, value){
                             ;

                             if(jQuery.inArray(value, arraycp)!=-1)
                             {

                                 // ie of array index find bug sloved here//
                                 if(!Array.indexOf){
                                     Array.prototype.indexOf = function(obj){
                                         for(var i=0; i<this.length; i++){
                                             if(this[i]==obj){
                                                 return i;
                                             }
                                         }
                                         return -1;
                                     }
                                 }

                                 var idx = arraycp.indexOf(value);
                                 //// Find the index

                                 if(idx!=-1) arraycp.splice(idx, 1); // Remove it if really found!

                                 u=0;

                             }
                             else{

                                 arraycp.push(value);



                             }


                         }


                     );

                         $.each(myArr,function(key, value){


                             if(jQuery.inArray(value, arraycp)!=-1)
                             {

                                 // ie of array index find bug sloved here//
                                 if(!Array.indexOf){
                                     Array.prototype.indexOf = function(obj){
                                         for(var i=0; i<this.length; i++){
                                             if(this[i]==obj){
                                                 return i;
                                             }
                                         }
                                         return -1;
                                     }
                                 }

                                 var idx = arraycp.indexOf(value); // Find the index
                                 if(idx!=-1) arraycp.splice(idx, 1); // Remove it if really found!

                                 u=0;


                             }
                             else{





                             }


                         }


                     );
                         $.each(arraycp,function(key, value){
                             myArr.push(value);

                         }


                     );

                        
// $("#txtEmpId").val(myArr);                        
//$("#frmSearchBox").submit();

                     }


            
            function checkValue(){
                $("#txtEmpId").val(myArr);
//                if($("#txtEmpId").val()==""){
//                    alert("<?php echo __('Please select a Employee') ?>");
//                    return false;
//                }
//                else{
//                    //alert($("#frmSearchBox").attr( txtEmpId, value ));
//                   
//                    }
                 $("#frmSearchBox").submit();
            }

            function popuimage(link){
                window.open(link, "myWindow",
                "status = 1, height = 300, width = 300, resizable = 0" )
            }
            function confirmdelet(){
                return false;

            }

            $(document).ready(function() {
                $("#searchMode:visible:first").focus();
                buttonSecurityCommon("buttonAdd",null,null,"buttonRemove");
                $('#dialog').hide();
                <?php if($EmpNo!=null){?>
                myArr="<?php echo $EmpNo; ?>";
                <?php } ?>
                //When click add button
                $("#buttonAdd").click(function() {
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/promotion/savePromotion')) ?>";

                });
                
                $('#empRepPopBtn').click(function() {
                    var popup=window.open('<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee?type=multiple&method=SelectEmployee'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');
                    if(!popup.opener) popup.opener=self;
                    popup.focus();
                    
                });

                // When Click Main Tick box
                $("#allCheck").click(function() {
                    if ($('#allCheck').attr('checked')){

                        $('.innercheckbox').attr('checked','checked');
                    }else{
                        $('.innercheckbox').removeAttr('checked');
                    }
                });

                $(".innercheckbox").click(function() {
                    if($(this).attr('checked'))
                    {

                    }else
                    {
                        $('#allCheck').removeAttr('checked');
                    }
                });


                $("#buttonRemove").click(function() {
                    $("#mode").attr('value', 'delete');
                    if($('input[name=chkLocID[]]').is(':checked')){
                        answer = confirm("<?php echo __("Do you really want to Delete?") ?>");
                    }


                    else{
                        alert("<?php echo __("select at least one check box to delete") ?>");

                    }

                    if (answer !=0)
                    {

                        $("#standardView").submit();

                    }
                    else{
                        return false;
                    }

                });

                //When click reset buton
                $("#resetBtn").click(function() {
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/promotion/HistoryPromotion')) ?>";
        });

	  	
    });


</script>

