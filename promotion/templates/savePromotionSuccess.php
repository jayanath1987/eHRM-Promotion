<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<link href="../../themes/orange/css/style.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery.placeholder.js') ?>"></script>
<?php
    //System Variables
    $sysConf = OrangeConfig::getInstance()->getSysConf();
    $inputDate = $sysConf->getDateInputHint();
    $dateDisplayHint = $sysConf->dateDisplayHint;
    $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
    if($update=="Update"){
    if ($lockMode == '1') {
        $editMode = false;
        $disabled = '';
    } else {
        $editMode = true;
        $disabled = 'disabled="disabled"';
    }
    }
?>

<div style="width: 800px"class="formpage4col" >
    <div class="navigation">

        <?php echo message() ?>

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Promotion") ?></h2></div>
        
          <?php if($update!="Update"){?>  
            <form enctype="multipart/form-data" action="<?php echo url_for('promotion/savePromotion') ?>" method="POST" id="frmPromotion" name="frmPromotion"  >
            <?php }else{?>
                <form enctype="multipart/form-data" action="<?php echo url_for('promotion/savePromotion?update=yes&id=' . $promotion->prm_id) ?>" method="POST" id="frmPromotion" name="frmPromotion"  >
                    <?php }?>
                <br class="clear"/>
<!--Employee Name-->
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Employee Name") ?> <span class="required">*</span>
                </label>
            </div>
            <div class="centerCol"  style="width:300px">
                <input type="text" class="formInputText" name="txtEmployeeName" disabled="disabled" id="txtEmployee" value="" readonly="readonly"  style="color: #222222"/>&nbsp;&nbsp;

                <input type="hidden" name="txtEmpId" id="txtEmpId" value=""/>
                <?php if($update!="Update"){ ?>
                <input class="button" style="margin-top: 7px;"type="button" value="..." id="empRepPopBtn" name="empRepPopBtn" <?php //echo $disabled; ?> />
                <?php } ?>
 </div>
                <br class="clear"/>   
<!--NIC Number -->
            <div class="leftCol">
                <label class="controlLabel" for="txtLatterId"><?php echo __("NIC Number") ?></label>
            </div>
            <div class="centerCol">
                <input type="text" value="" class="formInputText" name="txtNICNumber" id="txtNICNumber" maxlength="50" readonly="readonly"  style="color: #222222; cursor:none;"/>
            </div>
            <br class="clear"/>


<!--Current-->
            <div style="float: left; ">
                <fieldset style="min-height: 110px;">
                    <legend><?php echo __("Current") ?></legend>


<!--Designation -->
                    <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Designation:") ?> </label></div>
                    <input type="hidden" value="" class="formInputText"name="txtcdesg" id="txtcdesgid" />
                    <input type="text" name="txtMy" id="txtcdesg"  readonly="readonly" style="color: #222222; margin-top: 10px; cursor:none;"  >
                    <br class="clear"/>

<!--Employee Type-->
                    <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Employee Type:") ?> </label></div>
                    <input type="hidden" value="" class="formInputText" name="txtcetype" id="txtempctid" />
                    <input type="text" name="txtMy" id="txtempct"  readonly="readonly" style="color: #222222; margin-top: 10px; cursor:none;">
                    <br class="clear"/>

<!--Level-->
                    <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Level:") ?> </label></div>
                    <input type="text" name="Level" id="Level"  readonly="readonly" style="color: #222222; margin-top: 10px; cursor:none;">
                    <br class="clear"/>                      
<!--Service-->
                    <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Service:") ?> </label></div>

                    <input type="text" name="Service" id="Service"  readonly="readonly" style="color: #222222; margin-top: 10px; cursor:none;">
                    <br class="clear"/>                         
<!--Class-->
                    <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Class:") ?> </label></div>

                    <input type="text" name="txtClass" id="txtClass"  readonly="readonly" style="color: #222222; margin-top: 10px; cursor:none;">
                    <br class="clear"/>                    
<!--Grade-->
                    <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Grade:") ?> </label></div>

                    <input type="text" name="txtGrade" id="txtGrade"  readonly="readonly" style="color: #222222; margin-top: 10px; cursor:none;">
                    <br class="clear"/>    
<!--Grade Slot-->
                    <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Grade Slot:") ?> </label></div>

                    <input type="text" name="txtGradeSlot" id="txtGradeSlot"  readonly="readonly" style="color: #222222; margin-top: 10px; cursor:none;">
                    <br class="clear"/>   
                    
<!--Increment Date-->
                    <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Increment Date:") ?> </label></div>

                    <input type="text" name="IncrementDate" id="IncrementDate"  readonly="readonly" style="color: #222222; margin-top: 10px; cursor:none;">
                    <br class="clear"/>   
                    
<!--Work Station-->
                    <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Work Station:") ?> </label></div>
                    <input type="hidden" value="" class="formInputText" name="txtWorkStation" id="txtWorkStation" />
                    <br class="clear"/>
                        
                   <div id="Display1" >
                    </div> 
                    
                </fieldset>
            </div>
            <div style="float: right; width: 375px; ">
                <fieldset style="min-height: 110px;">
                    <legend><?php echo __("New") ?></legend>




<!--Designation-->
                    <div class="leftCol"> <label class="controlLabel" for="transfertypecombo"><?php echo __("Designation") ?><span class="required">*</span></label></div>
                    <div class="centerCol">
                    <select id="cmbDesg" name="cmbDesg" class="formSelect" style="width: 150px;height: 17px;margin-top: 8px;" <?php echo $disabled; ?>>
                        <option value=""><?php echo __("--Select--") ?></option>
                        <?php foreach ($promotiondesc as $promotionfdesc) {
                        ?>
                            <option value="<?php echo $promotionfdesc->getJobtit_code() ?>" <?php if($promotionfdesc->getJobtit_code()==$promotion->jobtit_code ){ echo "selected=selected"; } ?>><?php

                            if ($culture == 'en') {
                                $abcd = "getJobtit_name";
                            } else {
                                $abcd = "getJobtit_name_" . $culture;
                            }
                            if ($promotionfdesc->$abcd() == "") {
                                echo $promotionfdesc->getJobtit_name();
                            } else {
                                echo $promotionfdesc->$abcd();
                            }
                        ?></option>
                        <?php } ?>
                    </select>
                    </div>    
                    <br class="clear"/>


<!--Employee Type-->
                    <div class="leftCol"> <label class="controlLabel" for="transfertypecombo"><?php echo __("Employee Type:") ?><span class="required">*</span></label></div>
                    <div class="centerCol">
                    <select id="cmbEType" name="cmbEType" class="formSelect" style="width: 150px;height: 17px;margin-top: 8px;" <?php echo $disabled; ?>>
                        <option value=""><?php echo __("--Select--") ?></option>
                        <?php foreach ($promotionemptype as $promotionftype) {
                        ?>
                            <option value="<?php echo $promotionftype->getEstat_code() ?>" <?php if($promotionftype->getEstat_code()==$promotion->estat_code ){ echo "selected=selected"; } ?>><?php
                            if ($culture == 'en') {
                                $abcd = "getEstat_name";
                            } else {
                                $abcd = "getEstat_name_" . $culture;
                            }
                            if ($promotionftype->$abcd() == "") {
                                echo $promotionftype->getEstat_name();
                            }   else {
                                echo $promotionftype->$abcd();
                            }
                        ?></option>
                        <?php } ?>
                    </select>
                    </div>
                        <br class="clear"/>
<!--Level-->            
 <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Level:") ?><span class="required">*</span></label></div>
            <div class="centerCol"><select id="cmbLevel" id="cmbLevel" name="cmbLevel" class="formSelect" style="width: 150px;height: 17px;margin-top: 8px; " <?php echo $disabled; ?>>
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($Level as $promotionLevel) {
                    ?>
                        <option value="<?php echo $promotionLevel->level_code ?>" <?php if($promotionLevel->level_code==$promotion->level_code ){ echo "selected=selected"; } ?>><?php

                        if ($culture == 'en') {
                            $abcd = "level_name";
                        } else {
                            $abcd = "level_name_" . $culture;
                        }
                        if ($promotionLevel->$abcd == "") {
                            echo $promotionLevel->level_name;
                        } else {
                            echo $promotionLevel->$abcd;
                        }
                    ?></option>
                    <?php } ?>
                </select></div>
            <br class="clear"/>                     
<!--Service-->            
 <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Service:") ?><span class="required">*</span></label></div>
            <div class="centerCol"><select id="cmbService" name="cmbService" class="formSelect" style="width: 150px;height: 17px;margin-top: 8px; " <?php echo $disabled; ?>>
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($promotionservice as $promotionftype) {
                    ?>
                        <option value="<?php echo $promotionftype->getService_code() ?>"<?php if($promotionftype->getService_code()==$promotion->service_code ){ echo "selected=selected"; } ?>><?php

                        if ($culture == 'en') {
                            $abcd = "getService_name";
                        } else {
                            $abcd = "getService_name_" . $culture;
                        }
                        if ($promotionftype->$abcd() == "") {
                            echo $promotionftype->getService_name();
                        } else {
                            echo $promotionftype->$abcd();
                        }
                    ?></option>
                    <?php } ?>
                </select></div>
            <br class="clear"/> 
                
<!--Class-->
                    <div class="leftCol"> <label class="controlLabel" for="transfertypecombo"><?php echo __("Class:") ?><span class="required">*</span></label></div>
                    <div class="centerCol">
                    <select name="cmbClass" class="formSelect" style="width: 150px;height: 17px;margin-top: 8px;"  <?php echo $disabled; ?>>
                        <option value=""><?php echo __("--Select--") ?></option>
                        <?php foreach ($Class as $ClassDetail) {
                        ?>
                            <option value="<?php echo $ClassDetail->class_code; ?>"<?php if($ClassDetail->class_code==$promotion->class_code ){ echo "selected=selected"; } ?>><?php
                            if ($culture == 'en') {
                                $abcd = "class_name";
                            } else {
                                $abcd = "class_name_" . $culture;
                            }
                            if ($ClassDetail->$abcd == "") {
                                echo $ClassDetail->class_name;
                            } else {
                                echo $ClassDetail->$abcd;
                            }
                        ?></option>
                        <?php } ?>
                    </select>
                    </div>    
                    <br class="clear"/>
<!--Grade-->
                    <div class="leftCol"> <label class="controlLabel" for="transfertypecombo"><?php echo __("Grade:") ?><span class="required">*</span></label></div>
                    <div class="centerCol">
                    <select name="cmbGrade" class="formSelect" style="width: 150px;height: 17px;margin-top: 8px;" onchange="LoadGradeSlot(this.value);" <?php echo $disabled; ?>>
                        <option value=""><?php echo __("--Select--") ?></option>
                        <?php foreach ($Grade as $GradeDetail) {
                        ?>
                            <option value="<?php echo $GradeDetail->grade_code ?>"<?php if($GradeDetail->grade_code==$promotion->grade_code ){ echo "selected=selected"; } ?>><?php
                            if ($culture == 'en') {
                                $abcd = "grade_name";
                            } else {
                                $abcd = "grade_name_" . $culture;
                            }
                            if ($GradeDetail->$abcd == "") {
                                echo $GradeDetail->grade_name;
                            } else {
                                echo $GradeDetail->$abcd;
                            }
                        ?></option>
                        <?php } ?>
                    </select>
                    </div>    
                    <br class="clear"/>
<!--Grade Slot-->
                    <div class="leftCol"> <label class="controlLabel" for="transfertypecombo"><?php echo __("Grade Slot:") ?><span class="required">*</span></label></div>
                    <div class="centerCol" id="cmbGradeSlotDiv">
                    <select id="cmbGradeSlot" name="cmbGradeSlot" class="formSelect" style="width: 150px;height: 17px;margin-top: 8px;" <?php echo $disabled; ?> >
                        <option value=""><?php echo __("--Select--") ?></option>

                    </select>
                    </div>    
                    <br class="clear"/>
<!--Increment Date-->
                    <div class="leftCol"> <label class="controlLabel" for="transfertypecombo"><?php echo __("Increment Date:") ?><span class="required">*</span></label></div>
                    <div class="centerCol">
                    <input type="text" value="<?php echo $promotion->emp_salary_inc_date; ?>" class="formInputText" name="txtIncrementDate" id="txtIncrementDate" maxlength="20" style="width: 140px; height: 12px;" <?php echo $disabled; ?> />
                    </div>
                    
                    <br class="clear"/> 
<!--Work Station-->
                    <div class="leftCol"> <label class="controlLabel" for="transfertypecombo"><?php echo __("Work Station:") ?><span class="required">*</span></label></div>
                    <div class="leftCol" style="padding-top: 4px">  <input class="button" type="button"  onclick="returnLocDet1()" value="..." id="divisionPopBtn" <?php echo $disabled; ?> />
                    <label for="txtLocation" style="width: 2px;">
                      <input type="hidden" value="" class="formInputText" name="txtNWorkStaion" id="txtNWorkStaion" />    
                    </label>
                        </div><br class="clear">
                                                    
                                                    <div id="Display2" style="width: 100px;">
                                                    </div>
                    
                </fieldset>
            </div>
            <div style="clear: both;"> </div>



<!--Effective Date -->
            <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Effective Date") ?><span class="required">*</span> </label></div>
            <div class="centerCol"><input placeholder="<?php echo  $dateDisplayHint; ?>" id="effdate" type="text" class="formInputText" name="effdate" value="<?php echo $promotion->prm_effective_date; ?>" <?php echo $disabled; ?>></div>
            <div style="display: none;" class="demo-description"></div>
            <br class="clear"/>


<!--Commencement_date-->
            <div class="leftCol"><label class="controlLabel" for="txtLatterId"><?php echo __("Commencement Date") ?><span class="required">*</span></label></div>
            <div class="centerCol"><input type="text"  class="formInputText" name="txtCommencementdate" id="txtCommencementdate" maxlength="20" value="<?php echo $promotion->prm_commencement_date; ?>" <?php echo $disabled; ?> ></div>
            <br class="clear"/>
          
            
<!--Promotion Method-->
            <div class="leftCol"> <label class="controlLabel" for="txtLocationCode"><?php echo __("Promotion Method") ?><span class="required">*</span> </label></div>
            <div class="centerCol"><select name="txtprmmethod" class="formSelect" style="width: 150px;" <?php echo $disabled; ?>>
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($promotionMethod as $promotionftype) {
                    ?>
                            <option value="<?php echo $promotionftype->getPrm_method_id() ?>" <?php if($promotionftype->prm_method_id==$promotion->prm_method_id ){ echo "selected=selected"; } ?>><?php

                            if ($culture == 'en') {
                                $abcd = "getPrm_method_comment_en";
                            } else {
                                $abcd = "getPrm_method_comment_" . $culture;
                            }
                            if ($promotionftype->$abcd() == "") {
                                echo $promotionftype->getPrm_method_comment_en();
                            } else {
                                echo $promotionftype->$abcd();
                            }
                    ?></option>
                    <?php } ?>
                    </select></div>
                <br class="clear"/>

<!--Upload Letter-->

                <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Upload Letter") ?> </label></div>
                <div class="centerCol"><INPUT TYPE="file" class="formInputText" VALUE="Upload" name="txtletter" <?php echo $disabled; ?>></div>
                <?php if ($update=="Update") {
                ?><label style="margin-left :80px;"><a href="#" onclick="popupimage(link='<?php echo url_for('promotion/imagepop?id='); ?><?php echo $promotion->getPrm_id(); ?>')"><?php
                                $kk = $promotionDao->readattach($promotion->getPrm_id());
                                foreach ($kk as $rowa) {
                                    if ($rowa['count'] == 1) {
                                        echo __("View");
                                    }
                                }
                ?></a>  <a id="deletelink" onclick="return deletelink();"  href="<?php echo url_for('promotion/deletepop?id='); ?><?php echo $promotion->getPrm_id() ?>"> <?php
                                $kk = $promotionDao->readattach($promotion->getPrm_id());  
                                foreach ($kk as $rowa) {
                                    if ($rowa['count'] == 1) {
                                        echo __("Delete");
                                    }
                                }
                ?> </a></label> <?php } ?>
                
                <br class="clear"/>

<!--Comment-->

                <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Comment") ?> </label></div>
                <div class="centerCol"><textarea id="comment" class="formTextArea" name="comment" type="text" <?php echo $disabled; ?>><?php echo $promotion->prm_comment; ?></textarea></div>
                <br class="clear"/>
                
                <div id="DisciplinaryLink" class="leftCol" style="width:350px;">
                <a href='#' style='padding-left: 10px;' onclick='disHistoryPopup()'><?php echo __("Check Disciplinary Actions"); ?></a>
                </div>    
                <br class="clear"/>
                
                <?php if ($update!="Update") { ?>
                <div class="formbuttons">
                    <input type="hidden" value="" class="formInputText"  name="txtcserv" id="txtcserv" />

                    <input type="submit" id="editBtn" class = "plainbtn" value="<?php echo __("Save") ?>" />
                    <input type="reset" class = "plainbtn" value="<?php echo __("Reset") ?>"/>
                 
                    <input type="button" class="backbutton" id="btnBack"
                           value="<?php echo __("Back") ?>" />
                </div>
                <?php } else{?>
        <div class="formbuttons">
            <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                   value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
            <input type="reset" class="clearbutton" id="btnClear" 
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                   value="<?php echo __("Reset"); ?>" />
            <input type="button" class="backbutton" id="btnBack"
                   value="<?php echo __("Back") ?>"  onclick="goBack();"/>
        </div>
        <?php }?>
<input type="hidden" name="datehiddne" id="datehiddne" value=""/>

            </form>
        </div>
        <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
        <br class="clear" />
    </div>
<?php if ($update=="Update") { ?>

<?php }?>

                        <script type="text/javascript">
                            // <![CDATA[
                           
                           function dateAjaxValidation(str,eid){
                                    $.ajax({
                             type: "POST",
                             async:false,
                             url: "<?php echo url_for('promotion/DateValidation') ?>",
                             data: { sendValue: str, empId:eid },
                             dataType: "json",
                             success: function(data){ $("#datehiddne").val(data.message);}
                         });
                               

                            }
                           
                           
                           function popupimage(link){
                                window.open(link, "myWindow",
                                "status = 1, height = 300, width = 300, resizable = 0" )
                            }
                            
                                function disHistoryPopup(){
                                var empId=$("#txtEmpId").val();    
                                
    var encryptemp;
     $.ajax({
                             type: "POST",
                             async:false,
                             url: "<?php echo url_for('training/AjaxEncryption') ?>",
                             data: { empId: empId },
                             dataType: "json",
                             success: function(data){encryptemp = data;}
                         });
    
    
        window.open( "<?php echo url_for('disciplinary/empDisHistory?empId=') ?>"+encryptemp, "myWindow", "status = 1, height = 300, width = 825, resizable = 0" );
    }
                            
                            function deletelink(){

                                var conf= "<?php echo $conf; ?>";
                                if(conf!=1){
                                    answer = confirm("<?php echo __("Do you really want to Delete?") ?>");

                                    if (answer !=0)
                                    {

                                        return true;

                                        }
                                        else{
                                            return false;
                                        }}
                                    else{
                                        alert("<?php echo __("This is Confirmed record") ?>");
                                        return false;
                                    }
                                    
                                }
                            
                                                function returnLocDet1(){

                                                        // TODO: Point to converted location popup
                                                        var popup=window.open('<?php echo public_path('../../symfony/web/index.php/admin/listCompanyStructure?mode=select_subunit&method=mymethod'); ?>','Locations','height=450,resizable=1,scrollbars=1');
                                                        if(!popup.opener) popup.opener=self;
                                                    }
                                                    function mymethod(id,name){
                                                        //$("#txtDivisionid").val(id);
                                                        $("#txtNWorkStaion").val(id);
                                                        DisplayEmpHirache(id,"Display2");
                                                    }

                                            function DisplayEmpHirache(wst,div){
                                                        $('#'+div).val("");
                                                        var wst;
                                                        $.ajax({
                                                            type: "POST",
                                                            async:false,
                                                            url: "<?php echo url_for('promotion/DisplayEmpHirache') ?>",
                                                            data: { wst: wst },
                                                            dataType: "json",
                                                            success: function(data){
                                                                var row="<table style='background-color:#FAF8CC; width:350px; boder:1'>";
                                                                var temp=0;
                                                                if(data.name10 !=null){
                                                                    row+="<tr ><td style='width:300px'>"+data.nameLevel10+"-"+data.name10+"</td></tr>";
                                                                    temp=1;}
                                                                if(data.name9 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel9+"</label>-&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name9+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name8 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel8+"</label>-&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name8+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name7 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel7+"</label>-&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name7+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name6 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel6+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name6+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name5 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel5+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name5+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name4 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel4+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name4+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name3 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel3+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name3+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name2 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel2+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name2+"</td></tr>";
                                                                    temp=1;
                                                                }
                                                                if(data.name1 !=null){
                                                                    row+="<tr><td >";
                                                                    if(temp==1){
                                                                        row+="<label class='lbllevel' style='width:50px;'>"+data.nameLevel1+"</label>-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo public_path('../../themes/beyondT/icons/arrow.gif') ?>' border='0' alt='add' />";
                                                                    }
                                                                    row+=data.name1+"</td></tr>";
                                                                    temp=1;
                                                                }

                                                                row+="</table>";
                                                                $('#'+div).html(row);
                                                            }
                                                        });



                                                    }
                            
                            
                                                    function LoadGradeSlot(id){

                                                        $.ajax({
                                                            type: "POST",
                                                            async:false,
                                                            url: "<?php echo url_for('promotion/LoadGradeSlot') ?>",
                                                            data: { id: id },
                                                            dataType: "json",
                                                             success: function(data){

                                                             var selectbox="<select class='formSelect' id='cmbGradeSlot' name='cmbGradeSlot' style='width: 150px;height: 16px;'";
                                                            selectbox=selectbox +'<?php echo $disabled; ?>';
                                                             selectbox=selectbox +"><option value=''>"+"<?php echo __('--Select--'); ?>"+"</option>";
                                                            $.each(data, function(key, value) {
                                                                var word=value.split("|");
                                                                var sltid="<?php echo $promotion->slt_id; ?>";
                                                                selectbox=selectbox +"<option value='"+word[4]+"'";
                                                                if(word[4]== sltid){
                                                                  selectbox=selectbox +"selected=selected";  
                                                                }
                                                                selectbox=selectbox +">"+word[1]+" -- "+word[3]+"</option>";
                                                            });
                                                            selectbox=selectbox +"</select>";

                                                           $('#cmbGradeSlotDiv').html(selectbox);
                                                              }
                                                        });
                                                        }
                            
                            
                            
                            function SelectEmployee(data){
                                

                                myArr = data.split('|');
                                $("#txtEmpId").val(myArr[0]);
                                $("#txtEmployee").val(myArr[1]);
                                LoadCurrentDep1();
                            }
                            function formValidation(){

                                if($("#txtEmpId").val()==""){
                                    alert("please Select the Employee Name");
                                    return false;
                                }
                                if($("#datepicker").val()==""){
                                    alert("Please Enter Date");
                                    return false;
                                }
                            }

                            function LoadCurrentDep1(){

                                sendValue($("#txtEmpId").val());
                            }

                            function sendValue(str){
                                $.ajax({
                                    type: "POST",
                                    async:false,
                                    url: "<?php echo url_for('promotion/AjaxCall') ?>",
                                    data: { sendValue: str },
                                    dataType: "json",
                                    success: function(data){
                                
                                    $("#txtE").val(data.returnValue);
                                    $("#txtcgid").val(data.gid);
                                    $("#txtcdesg").val(data.desgname);
                                    $("#txtcdesgid").val(data.desgid);
                                    $("#txtempct").val(data.empct);
                                    $("#txtempctid").val(data.empctid);
                                    $("#txtempcdev").val(data.empcdev);
                                    $("#txtempcdevid").val(data.empcdevid);
                                    $("#txtcserv").val(data.empcdevid);
                                    $("#txtNICNumber").val(data.empnic);
                                    $("#txtClass").val(data.Class);
                                    $("#txtGrade").val(data.Gradename);
                                    $("#txtGradeSlot").val(data.GradeSlot);
                                    $("#IncrementDate").val(data.IncrementDate);
                                    $("#txtWorkStation").val(data.Workstation);
                                    $("#Service").val(data.Service);
                                    $("#Level").val(data.Level);
                                    DisplayEmpHirache(data.Workstation,"Display1");

                                }

                            });

                            }
                            $(document).ready(function() {
                                
                                    buttonSecurityCommon(null,null,"editBtn",null);
                                    
<?php
    if($update=="Update"){
         if ($editMode == true) { ?>
                                                $('#frmSave :input').attr('disabled', true);
                                                $('#editBtn').removeAttr('disabled');
                                                $('#btnBack').removeAttr('disabled');
                                    <?php } ?>
        
            var empnumber="<?php echo $promotion->emp_number; ?>";
            var empname="<?php if($culture=="en"){ echo $promotion->Employee->emp_display_name;}else if($culture=="si"){ echo $promotion->Employee->emp_display_name_si; }else if($culture=="ta"){ echo $promotion->Employee->emp_display_name_ta; } ?>";
            if(empname==""){
                empname="<?php echo $promotion->Employee->emp_display_name; ?>"
            }
            //var data=empnumber+"|"+empname;
           // SelectEmployee(data);
            var grade="<?php echo $promotion->grade_code; ?>";
            LoadGradeSlot(grade);
            var gradecode="<?php echo $promotion->slt_id; ?>";
            $('#cmbGradeSlot').val(gradecode);
            var divition="<?php echo $promotion->prm_divition; ?>";
            mymethod(divition,"null")
            DisplayEmpHirache("<?php echo $promotion->prm_prev_work_station; ?>","Display1");
           <?php
           if($promotion->prm_prev_jobtit_code!= null){
                if($culture=="en"){ 
                    $PreviousDesignation=$promotion->cJobTitle->name;
                    
                }else if($culture=="si"){ 
                    $PreviousDesignation=$promotion->cJobTitle->name_si; 
                        
                }else if($culture=="ta"){ 
                    $PreviousDesignation=$promotion->cJobTitle->name_ta;
                }
                if($PreviousDesignation==null){
                    $PreviousDesignation=$promotion->cJobTitle->name;
                }
            }
           if($promotion->prm_prev_work_station!= null){
                if($culture=="en"){ 
                    $CompanyStructure=$promotion->cCompanyStructure->title;
                    
                }else if($culture=="si"){ 
                    $CompanyStructure=$promotion->cCompanyStructure->title_si; 
                        
                }else if($culture=="ta"){ 
                    $CompanyStructure=$promotion->cCompanyStructure->title_ta;
                }
                if($CompanyStructure==null){
                    $CompanyStructure=$promotion->cCompanyStructure->title;
                }
            }  
            if($promotion->prm_prev_emp_status!= null){
                if($culture=="en"){ 
                    $EmployeeStatus=$promotion->cEmployeeStatus->name;
                    
                }else if($culture=="si"){ 
                    $EmployeeStatus=$promotion->cEmployeeStatus->estat_name_si; 
                        
                }else if($culture=="ta"){ 
                    $EmployeeStatus=$promotion->cEmployeeStatus->estat_name_ta;
                }
                if($EmployeeStatus==null){
                    $EmployeeStatus=$promotion->cEmployeeStatus->name;
                }
            } 
            if($promotion->prm_prev_level_code!= null){
                if($culture=="en"){ 
                    $Level=$promotion->cLevel->level_name;
                    
                }else if($culture=="si"){ 
                    $Level=$promotion->cLevel->level_name_si; 
                        
                }else if($culture=="ta"){ 
                    $Level=$promotion->cLevel->level_name_ta;
                }
                if($Level==null){
                    $Level=$promotion->cLevel->level_name;
                }
            }
            if($promotion->prm_prev_service_code!= null){
                if($culture=="en"){ 
                    $ServiceDetails=$promotion->cServiceDetails->service_name;
                    
                }else if($culture=="si"){ 
                    $ServiceDetails=$promotion->cServiceDetails->service_name_si; 
                        
                }else if($culture=="ta"){ 
                    $ServiceDetails=$promotion->cServiceDetails->service_name_ta;
                }
                if($ServiceDetails==null){
                    $ServiceDetails=$promotion->cServiceDetails->service_name;
                }
            }
            if($promotion->prm_prev_class_code!= null){
                if($culture=="en"){ 
                    $EmpClass=$promotion->cEmpClass->class_name;
                    
                }else if($culture=="si"){ 
                    $EmpClass=$promotion->cEmpClass->class_name_si; 
                        
                }else if($culture=="ta"){ 
                    $EmpClass=$promotion->cEmpClass->class_name_ta;
                }
                if($EmpClass==null){
                    $EmpClass=$promotion->cEmpClass->class_name;
                }
            }
            if($promotion->prm_prev_grade!= null){
                if($culture=="en"){ 
                    $Grade=$promotion->cGrade->grade_name;
                    
                }else if($culture=="si"){ 
                    $Grade=$promotion->cGrade->grade_name_si; 
                        
                }else if($culture=="ta"){ 
                    $Grade=$promotion->cGrade->grade_name_ta;
                }
                if($Grade==null){
                    $Grade=$promotion->cGrade->grade_name;
                }
            }
            if($promotion->prm_prev_emp_salary_inc_date!= null){
                   $incrimentdate=$promotion->prm_prev_emp_salary_inc_date;
            }
            if($promotion->prm_prev_slt_id!=null){
                $gradeslot=$salary->slt_scale_year." -> ".$salary->emp_basic_salary;
               
            }
            ?>
            $("#txtEmployee").val(empname);
            $("#txtEmpId").val(empnumber);
            $("#txtNICNumber").val("<?php echo $promotion->Employee->emp_nic_no; ?>");
            $("#txtcdesg").val("<?php echo $PreviousDesignation; ?>");
            $("#txtempct").val("<?php echo $EmployeeStatus; ?>");
            $("#Level").val("<?php echo $Level; ?>");
            $("#Service").val("<?php echo $ServiceDetails; ?>");
            $("#txtClass").val("<?php echo $EmpClass; ?>");
            $("#txtGrade").val("<?php echo $Grade; ?>");
            $("#IncrementDate").val("<?php echo $incrimentdate; ?>");
            $("#txtGradeSlot").val("<?php echo $gradeslot; ?>");
        
        <?php
        }
        ?>                      $("#effdate").placeholder();
                                $("#txtCommencementdate").placeholder();
                                $("#txtCommencementdate").placeholder();
                                $("#txtIncrementDate").placeholder();
                               // buttonSecurityCommon(null,"editBtn",null,null);

                                jQuery.validator.addMethod("orange_date",
                                function(value, element, params) {

                                    //var hint = params[0];
                                    var format = params[0];

                                    // date is not required
                                    if (value == '') {

                                        return true;
                                    }
                                    var d = strToDate(value, "<?php echo $format ?>");


                                    return (d != false);

                                }, ""
                            );
                            
                            jQuery.validator.addMethod("validateJoinDate",
                                function(value, element, params) {

                                    if($("#datehiddne").val()=="error"){
                                        return false;
                                    }else{
                                             return true;
                                    }

                                }, ""
                            );
                                
                            jQuery.validator.addMethod("validateEffectiveDate",
                                function(value, element, params) {

                                    if($("#txtCommencementdate").val() < $("#effdate").val()){
                                        return false;
                                    }else{
                                             return true;
                                    }

                                }, ""
                            );

                                $("#frmPromotion").validate({

                                    rules: {
                                        txtEmpId: { required: true },
                                        cmbDesg: { required: true },
                                        cmbEType: { required: true },
                                        cmbLevel: { required: true },
                                        cmbService: { required: true },
                                        cmbClass: { required: true },
                                        cmbGrade: { required: true },
                                        cmbGradeSlot: { required: true },
                                        txtIncrementDate: { required: true,orange_date:true },
                                        txtCommencementdate: { required: true ,orange_date:true ,validateEffectiveDate:true },
                                        txtNWorkStaion: { required: true },
                                        effdate: { required: true ,validateJoinDate: true},
                                        datepicker: { required: true ,orange_date: true },
                                        comment: { noSpecialCharsOnly: true, maxlength:200 },
                                        txtprmmethod: { required: true }

                                    },
                                    messages: {
                                        txtEmpId: "<?php echo __("This Field is required") ?>",
                                        cmbDesg: "<?php echo __("This Field is required") ?>",
                                        cmbEType: "<?php echo __("This Field is required") ?>",
                                        cmbLevel: "<?php echo __("This Field is required") ?>",
                                        cmbService: "<?php echo __("This Field is required") ?>",
                                        cmbClass: "<?php echo __("This Field is required") ?>",
                                        cmbGrade: "<?php echo __("This Field is required") ?>",
                                        effdate: { required: "<?php echo __("This Field is required") ?>" ,validateJoinDate :"<?php echo __('Effective Date Error, Alredy Promotion Exist.') ?>"},
                                        cmbGradeSlot: "<?php echo __("This Field is required") ?>",
                                        txtIncrementDate: {required:"<?php echo __("This Field is required") ?>",orange_date: "<?php echo __("Please specify valid date") ?>"},
                                        txtCommencementdate: {required:"<?php echo __("This Field is required") ?>",orange_date: "<?php echo __("Please specify valid date") ?>", validateEffectiveDate : "<?php echo __("Commencement date greater than to Effective date ") ?>"},
                                        txtNWorkStaion: "<?php echo __("This Field is required") ?>",
                                        datepicker: {required:"<?php echo __("This Field is required") ?>",orange_date: "<?php echo __("Please specify valid date") ?>"},
                                        comment: {maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>" },
                                        txtprmmethod: "<?php echo __("This Field is required") ?>"

                                    }
                                });


                                if($("#transfertype").val==2){
                                    $("#location").show();
                                }
                                else{
                                    $("#location").hide();
                                }

                                $("#transfertype").change(function () {
                                    var src = $("option:selected", this).val();
                                    if(src==2){
                                        $("#location").show();
                                    }
                                    else{
                                        $("#location").hide();
                                    }
                                });

                                $('#empRepPopBtn').click(function() {
                                    var popup=window.open('<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee?type=single&method=SelectEmployee'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');
                                    if(!popup.opener) popup.opener=self;
                                    popup.focus();
                                });



                                $("#effdate").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });
                                $("#txtCommencementdate").datepicker({ dateFormat: '<?php echo $inputDate; ?>'});
                                $("#txtIncrementDate").datepicker({ dateFormat: '<?php echo $inputDate; ?>'});
                                if ($(('input#isMutual')).attr("checked")) {
                                    $("#mname").show();
                                }
                                else{
                                    $("#mname").hide();
                                }
                                $("#effdate").change(function () {
                                    dateAjaxValidation($("#effdate").val(),$("#txtEmpId").val());
                                }); 

                                $('input#isMutual').change(function () {
                                    if ($(this).attr("checked")) {
                                        //do the stuff that you would do when 'checked'
                                        $("#mname").show();

                                        return;
                                    }else{
                                        $("#mname").hide();
                                    }
                                    //Here do the stuff you want to do when 'unchecked'
                                });

                                $("#frmPromotion").data('edit', <?php echo $editMode ? '1' : '0' ?>);
                                // When click edit button
                                $("#editBtn").click(function() {
                                    //$('#frmPromotion').submit();
                                    var editMode = $("#frmPromotion").data('edit');
                                    if (editMode == 1) {
                                        // Set lock = 1 when requesting a table lock

                                        location.href="<?php echo url_for('promotion/savePromotion?update=yes&id=' . $promotion->prm_id . '&lock=1') ?>";
                                    }
                                    else {
                                        if($("#effdate").val()!="" && $("#txtEmpId").val()!=""){
                                            dateAjaxValidation($("#effdate").val(),$("#txtEmpId").val());
                                        }

                                        $('#frmPromotion').submit();
                                    }
                                });

                                //When click reset buton
                                $("#resetBtn").click(function() {
                                    document.forms[0].reset('');
                                });

                                //When Click back button
                                $("#btnBack").click(function() {
                                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/promotion/listPromotion')) ?>";

                                });
                            });

                            function returnLocDet(){

                                // TODO: Point to converted location popup
                                var popup=window.open('<?php echo public_path('../../symfony/web/index.php/admin/listCompanyStructure?mode=select_subunit&method=mymethod1'); ?>','Locations','height=450,resizable=1,scrollbars=1');
        if(!popup.opener) popup.opener=self;
    }
    function mymethod1(id,name){

    //alert("id");
        //$("#cmbLocation").val($id);
        //$("#txtLocation").val($name);
        //$("#txtWorkStation").val(id);
    }
    // ]]>
</script>
