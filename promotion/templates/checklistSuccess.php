<?php
if ($lockMode == '1') {
    $editMode = false; 
    $disabled = ''; ?>

 <?php
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}

$comleteDate = LocaleUtil::getInstance()->formatDate($employee->emp_birthday);
require_once ROOT_PATH . '/lib/common/LocaleUtil.php';
?>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery.placeholder.js') ?>"></script>
<?php

                    $sysConf = OrangeConfig::getInstance()->getSysConf();
                    $inputDate = $sysConf->getDateInputHint();
                    $dateDisplayHint = $sysConf->dateDisplayHint;
                    $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>
<div class="formpage4col">
    <div class="navigation">

        
    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Check List") ?><?php  if($culture=="en"){ echo " ( ".$employee->emp_display_name." ) ";}else if($culture=="si"){ echo " ( ".$employee->emp_display_name_si." ) "; }else if($culture=="ta"){ echo " ( ".$employee->emp_display_name_ta." ) "; } ?></h2></div><?php echo message() ?>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <?php echo $form['_csrf_token']; ?>
            <br class="clear">
            <table cellpadding="0" cellspacing="0" class="data-table">
                <thead>
                    <tr>
                        <td scope="col" style="width: 250px;">
                            <div class="leftCol" style="width: 250px;margin-left: 20px;" >
                                <?php echo __("CheckList") ?>
                            </div>
                        </td>
                        <td scope="col" style="width: 50px;">
                            <div class="centerCol" style="width: 50px;">
                                <?php echo __("Validate") ?>
                            </div>
                        </td>
                        <td scope="col" style="width: 100px;">
                            <div class="rightCol" style="width: 100px;">
                                <?php echo __("Date completed") ?>
                            </div>
                        </td>
                        <td scope="col" style="width: 100px;">
                            <div class="rightCol" style="width: 100px;">
                                <?php echo __("Reason") ?>
                            </div>
                        </td>
                    </tr>
                </thead>
                <br class="clear"/>

                <?php
                                $CHKDTID = array();
                                $max = $PromotionCkecklistmax[0]['count'];
                                $row = 0; ?>

                                <input type="hidden" name="cklmax" value="<?php echo $max; ?>">

                <?php
                                $CHKDTID = array();
                                //for ($i = 0; $i < $max; $i++) {
                                foreach($PromotionCkecklist as $data){
                                    $cssClass = ($row % 2) ? 'even' : 'odd';
                                    $row = $row + 1;
                ?>
                <?php
                                    if ($data['prm_checklist_id']!=null){
                                    //define datearray
                                    array_push($CHKDTID, $data['prm_checklist_id'])
                ?>
                                    <tr class="<?php echo $cssClass ?>">
                                        <td class="">
                                            <div class="leftCol" style="width: 250px;margin-left: 20px;" >
                            <?php
                                    if ($data['prm_checklist_name_' . $culture] == null) {
                                        echo $data['prm_checklist_name_en'];
                                    } else {
                                        echo $data['prm_checklist_name_' . $culture];
                                    }
                            ?>
                                </div>
                            </td>

                            <td class="">
                                <div class="leftCol" style="width: 2px;" align="center">
                                    <input  type="checkbox" class='checkbox innercheckbox' id="<?php echo "ck" . $data['prm_checklist_id']; ?>" name="<?php echo "ck" . $data['prm_checklist_id']; ?>" value="1"<?php
                                    foreach ($PromotionCkeckdetals as $sel) {
                                        if ($data['prm_checklist_id'] == $sel['prm_checklist_id'] ) {
                                            if ($sel['prm_value']== "1") {
                                               echo "checked"; 
                                            }
                                            
                                        }
                                    }
                            ?> ></div>
                     </td>
                     <td class="" >
                         <div class="leftCol" style="width: 0.5px">
                             <input type="text" class="formInputText"style="width:80px;margin-left: 0px;" placeholder="<?php echo  $dateDisplayHint; ?>" name="<?php echo "txtComepDate_" . $data['prm_checklist_id']; ?>" id="<?php echo "txtComepDate_" . $data['prm_checklist_id']; ?>"
                                    value="<?php
                                    foreach ($PromotionCkeckDatedetals as $sel) {

                                        if ($data['prm_checklist_id'] == $sel['prm_checklist_id']) {
                                            $date=$sel['prm_complete_date'];
                                            echo $date;
                                        }
                                    }
                            ?>" />
                         </div>
                         </td>
                         <td class="">
                         <div class="leftCol" style="width: 0.5px">
                             <input type="text" class="formInputText" maxlength="200" style="width:80px;margin-left: 0px;" onkeypress='return validationDesc(event,this.id)'  name="<?php echo "txtComment_" . $data['prm_checklist_id']; ?>" id="<?php echo "txtComment_" . $data['prm_checklist_id']; ?>"
                                    value="<?php
                                    foreach ($PromotionCkeckComment as $sel) {

                                        if ($data['prm_checklist_id'] == $sel['prm_checklist_id']) {
                                            $comment=$sel['prm_comment'];
                                            echo $comment;
                                        }
                                    }
                            ?>" <?php echo $disabled; ?> />
                         </div>
                         </td>
                        <?php
                                    }   } //}
                        ?>
                            
                        </tr>
                    </table>


                    <br class="clear"/>
                    <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Overall Comment") ?> </label></div>
                <div class="centerCol"><textarea id="ovrcomment" class="formTextArea" name="ovrcomment" type="text" <?php echo $disabled; ?>><?php echo $PromotionCkeckdetals['1']['prm_ovr_comment']; ?></textarea></div>
                <br class="clear"/>
                
                        
                    
                    
                </form>

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


            </div>

        </div>
<?php
                                require_once '../../lib/common/LocaleUtil.php';
                                $sysConf = OrangeConfig::getInstance()->getSysConf();
                                $sysConf = new sysConf();
                                $inputDate = $sysConf->dateInputHint;
                                $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>
                                <script language="javascript">

                                    var scriptAr = new Array(); // initializing the javascript array
<?php
                                foreach ($CHKDTID as $value) {
                                    print "scriptAr.push(\"$value\");";  //This line updates the script array with new entry
                                }
?>
                                </script>
                                <script type="text/javascript">
           function validationDesc(event,id){
                 var code = event.which || event.keyCode;

            // 65 - 90 for A-Z and 97 - 122 for a-z 95 for _ 45 for - 46 for .
            if (!((code >= 48 && code <= 57) || (code >= 65 && code <= 90) || (code >= 97 && code <= 122) || code == 95 || code == 46 || code == 45 || code == 32 || code == 9 || code == 13 || code == 20 ))
            {
                        $('#'+id).val("");
                        return false;
            }
            if($('#'+id).val().length>200){
                alert("<?php echo __('Maximum length should be 200 characters') ?>");
                $('#'+id).val("");
                return false;
            }
            }
                                    $(document).ready(function() {                                           $("#editBtn:visible:first").focus();

                                        buttonSecurityCommon(null,null,"editBtn",null);




                                        for(i=0;i<scriptAr.length;i++){
                                            $("#txtComepDate_"+scriptAr[i]).placeholder();
                                            $("#txtComepDate_"+scriptAr[i]).datepicker({ dateFormat: '<?php echo $inputDate ?>' });
                                        }

<?php if ($editMode == true) { ?>
                                    $('#frmSave :input').attr('disabled', true);
                                    $('#editBtn').removeAttr('disabled');
                                    $('#btnBack').removeAttr('disabled');
                                    
                                    //page load time disabel
                                        $(function(){
                                            $('.formInputText').each(function(){
                                                if ($(this).val() === '') {
                                                    $(this).attr('disabled', 'disabled');
                                                }
                                            });
                                        });


<?php } ?>

                                $("#frmSave").validate({

                                    rules: {
                                        ovrcomment: { noSpecialCharsOnly: true, maxlength:200 }

                                    },
                                    messages: {                                        
                                        ovrcomment: {maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>" }

                                    }
                                });


                                $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                                $("#editBtn").click(function() {

                                var editMode = $("#frmSave").data('edit');
                                if (editMode == 1) {
                                // Set lock = 1 when requesting a table lock

                                location.href="<?php echo url_for('promotion/checklist?id=' . $kk . '&lock=1') ?>";
                                }
                                else {
                                    
                                
                                    
                                var max="<?php echo $max; ?>";
                                var count = 0;
                                <?php foreach($PromotionCkecklist as $data){ ?>
                                //for(var i=1; i<= max; i++){
                                var i="<?php echo $data['prm_checklist_id'];?>";
                                if ($('#ck'+i).attr('checked')) {
                                    var today="<?php echo date("Y-m-d"); ?>"
                                    if($("#txtComepDate_"+i).val() > today){ 
                                      alert("<?php echo __("Date completed canot be future date.")?>");  
                                      count++; 
                                      return false;
                                    }
                                }
                                //}
                                <?php } ?>
                                if(count == 0){                          
                                    
                                $('#frmSave').submit();
                                }

                                //}

                                }
                                });

                                //When Click back button
                                $("#btnBack").click(function() {
                                location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/promotion/probationlist')) ?>";
                                });

                                //When click reset buton
                                $("#btnClear").click(function() {
                                // Set lock = 0 when resetting table lock
                                location.href="<?php echo url_for('promotion/checklist?id=' . $kk . '&lock=0') ?>";
});
                          


});
</script>
