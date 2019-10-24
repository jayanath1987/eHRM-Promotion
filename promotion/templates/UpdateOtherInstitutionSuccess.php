<?php
if ($lockMode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
    $sysConf = OrangeConfig::getInstance()->getSysConf();
    $inputDate = $sysConf->getDateInputHint();
    $dateDisplayHint = $sysConf->dateDisplayHint;
    $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
        $encrypt = new EncryptionHandler();
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery.placeholder.js') ?>"></script>

<div class="formpage4col" >
    <div class="navigation">
        <style type="text/css">
        div.formpage4col input[type="text"]{
            width: 180px;
        }
        </style>

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Other Institutions") ?></h2></div>
            <?php echo message() ?>
            <?php echo $form['_csrf_token']; ?>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <div class="leftCol">
                &nbsp;
            </div>
            
            <br class="clear"/>
                        <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Employee Name") ?> <span class="required">*</span>
                </label>
            </div>
            <div class="centerCol"  style="width:300px">
                <input type="text" class="formInputText" name="txtEmployeeName"  id="txtEmployee" value="" readonly="readonly"  style="color: #222222"/>&nbsp;&nbsp;

                <input type="hidden" name="txtEmpId" id="txtEmpId" value=""/>
                <?php if($update!="Update"){ ?>
                <input class="button" style="margin-top: 7px;"type="button" value="..." id="empRepPopBtn" name="empRepPopBtn" <?php //echo $disabled; ?> />
                <?php } ?>
            </div>
            <br class="clear"/>       
             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Employee Number") ?></label>
            </div>
            <div class="centerCol">
                <input id="txtEmployeeNumber" type="text"  name="txtEmployeeNumber" readonly="readonly" style="color: #222222; margin-top: 10px; cursor:none;"  class="formInputText" value="<?php //echo $OtherInstitute->oth_institute_name; ?>" />
            </div>
            <br class="clear"/>
            <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Designation:") ?> </label></div>
            <div class="centerCol">        
            <input type="hidden" value="" class="formInputText"name="txtcdesg" id="txtcdesgid" />
                    <input type="text" class="formInputText" name="txtMy" id="txtcdesg"  readonly="readonly" style="color: #222222; margin-top: 10px; cursor:none;" >
            </div>
            <br class="clear"/>
            <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Work Station:") ?> </label></div>
                    <input type="hidden" value="" class="formInputText" name="txtWorkStation" id="txtWorkStation" />
                    <br class="clear"/>
                        
                   <div id="Display1" >
                    </div>
             <br class="clear"/>       
             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Institute") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtInstitute"  name="txtInstitute" type="text"  class="formInputText" value="<?php echo $OtherInstitute->oth_institute_name; ?>" maxlength="200" />
            </div>
            <br class="clear"/>
             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Released Location") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtReleasedLocation"  name="txtReleasedLocation" type="text"  class="formInputText" value="<?php echo $OtherInstitute->oth_release_location ; ?>" maxlength="200" />
            </div>
            <br class="clear"/>
             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Released Period From") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtReleasedPeriodFrom"  name="txtReleasedPeriodFrom" type="text"  class="formInputText" value="<?php echo $OtherInstitute->oth_release_from ; ?>" maxlength="200" />
            </div>
            <br class="clear"/>            
             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Released Period To") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtReleasedPeriodTo"  name="txtReleasedPeriodTo" type="text"  class="formInputText" value="<?php echo $OtherInstitute->oth_release_to; ?>" maxlength="200" />
            </div>
            <br class="clear"/>            
             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Payroll Active") ?> </label>
            </div>
            <div class="centerCol">
                <input id="cmbPayrollActive"  name="cmbPayrollActive" type="checkbox" value="1" class="formInputText" <?php if($OtherInstitute->oth_payroll_active_flg=="1"){ echo "checked";  } ?>  />
            </div>
            <br class="clear"/>
             <div class="leftCol">
                <label for="txtLocationCode"><?php echo __("Reason") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txtReason"  name="txtReason" type="text"  class="formInputText" value="<?php echo $OtherInstitute->oth_reason; ?>" maxlength="200" />
            </div>
            <br class="clear"/>            


            <br class="clear"/>
            <br class="clear"/>
        <div class="formbuttons">
            <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                   value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
            <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                   value="<?php echo __("Reset"); ?>" />
            <input type="button" class="backbutton" id="btnBack"
                   value="<?php echo __("Back") ?>" tabindex="18"  onclick="goBack();"/>
        </div>
        </form>
    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />
</div>


<script type="text/javascript">
                            function SelectEmployee(data){
                                
                                myArr = data.split('|');
                                $("#txtEmpId").val(myArr[0]);
                                $("#txtEmployee").val(myArr[1]);
                                sendValue(myArr[0]);
                            }
                            
                            function sendValue(str){
                                $.post(

                                "<?php echo url_for('promotion/AjaxCall') ?>",  //Ajax file

                                { sendValue: str },  // create an object will all values

                                //function that is called when server returns a value.
                                function(data){ 
                                    $("#txtE").val(data.returnValue);
                                    $("#txtcdesg").val(data.desgname);
                                    $("#txtempcdev").val(data.empcdev);
                                    $("#txtEmployeeNumber").val(data.EmpNumber);
                                    DisplayEmpHirache(data.Workstation,"Display1");

                                },

                                //How you want the data formated when it is returned from the server.
                                "json"
                            );

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
                            
    $(document).ready(function() {
        buttonSecurityCommon("null","null","editBtn","null");
        
                  $("#txtReleasedPeriodFrom").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });
                  $("#txtReleasedPeriodTo").datepicker({ dateFormat: '<?php echo $inputDate; ?>'});
        
        var empnumber="<?php echo $OtherInstitute->emp_number; ?>";
            var empname="<?php if($myCulture=="en"){ echo $OtherInstitute->Employee->emp_display_name;}else if($myCulture=="si"){ echo $OtherInstitute->Employee->emp_display_name_si; }else if($myCulture=="ta"){ echo $OtherInstitute->Employee->emp_display_name_ta; } ?>";
            if(empname==""){
                empname="<?php echo $promotion->Employee->emp_display_name; ?>"
            }
            var data=empnumber+"|"+empname;
            SelectEmployee(data);
<?php if ($editMode == true) { ?>
                              $('#frmSave :input').attr('disabled', true);
                              $('#editBtn').removeAttr('disabled');
                              $('#btnBack').removeAttr('disabled');
<?php } ?>

                       //Validate the form
                       $("#frmSave").validate({

            rules: {
                txtEmployeeName:{required: true},
                txtInstitute:{required: true,noSpecialCharsOnly: true, maxlength:200},
                txtReleasedLocation: { required: true,noSpecialCharsOnly: true, maxlength:200 },
                txtReleasedPeriodFrom: {required: true,noSpecialCharsOnly: true, maxlength:200 },
                txtReleasedPeriodTo: {required: true,noSpecialCharsOnly: true, maxlength:200 },
                txtReason: {required: true,noSpecialCharsOnly: true, maxlength:200 }
                //cmbPayrollActive:{required: true}
            },
            messages: {
                txtEmployeeName:{required:"<?php echo __("This field is required") ?>"},
                txtInstitute:{required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtReleasedLocation: {required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtReleasedPeriodFrom:{required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtReleasedPeriodTo:{required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"},
                txtReason:{required:"<?php echo __("This field is required") ?>",maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"}
                //cmbPayrollActive:{required:"<?php echo __("This field is required") ?>"}

            }
        });
        
        
                        $('#empRepPopBtn').click(function() {
                                    var popup=window.open('<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee?type=single&method=SelectEmployee'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');
                                    if(!popup.opener) popup.opener=self;
                                    popup.focus();
                        });

                       // When click edit button
                       $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                       $("#editBtn").click(function() {

                           var editMode = $("#frmSave").data('edit');
                           if (editMode == 1) {
                               // Set lock = 1 when requesting a table lock

            location.href="<?php echo url_for('promotion/UpdateOtherInstitution?id=' . $encrypt->encrypt($OtherInstitute->oth_inst_id ) . '&lock=1') ?>";
                           }
                           else {
                               
                               if($("#txtReleasedPeriodFrom").val() > $("#txtReleasedPeriodTo").val()){
                                   alert("<?php echo __("Invalid Released Period") ?>");
                                   return false;
                               }

                               $('#frmSave').submit();
                           }


                       });

                       //When Click back button
                       $("#btnBack").click(function() {
                           location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/promotion/OtherInstitution')) ?>";
                       });

                       //When click reset buton
                       $("#btnClear").click(function() {
                           // Set lock = 0 when resetting table lock
                           <?php if($OtherInstitute->oth_inst_id){ ?>
                              location.href="<?php echo url_for('promotion/UpdateOtherInstitution?id=' . $encrypt->encrypt($OtherInstitute->oth_inst_id ) . '&lock=0') ?>"; 
                           <?php }else{ ?>
                              location.href="<?php echo url_for('promotion/UpdateOtherInstitution') ?>";  
                           <?php } ?>
                       });
                   });
</script>
