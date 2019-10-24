<?php
if ($lockMode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<div class="formpage4col">
    <div class="navigation">


    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Edit Promotion Check List") ?></h2></div>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <?php echo message() ?>
            <?php echo $form['_csrf_token']; ?>

            <div class="leftCol">
                &nbsp;
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("English") ?></label>
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("Sinhala") ?></label>
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("Tamil") ?></label>
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label  for="txtLocationCode"><?php echo __("Checklist Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">

                <textarea id="txtName"  name="txtName" type="text"  class="formTextArea" value=""  ><?php echo $PromotionCkecklist->getPrm_checklist_name_en() ?> </textarea>
            </div>



            <div class="centerCol">
                <textarea id="txtJobTitleDesc" class="formTextArea"  name="txtNamesi" type="text"><?php echo $PromotionCkecklist->getPrm_checklist_name_si() ?></textarea>

            </div>

            <div class="centerCol">
                <textarea id="txtJobTitleComments" class="formTextArea"  name="txtNameta" type="text"><?php echo $PromotionCkecklist->getPrm_checklist_name_ta() ?></textarea>

            </div>
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
                   value="<?php echo __("Back") ?>" onclick="goBack();"/>
        </div>
    </div>
    <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
    <br class="clear" />

</div>

<script type="text/javascript">

    $(document).ready(function() {

        buttonSecurityCommon(null,null,"editBtn",null);

<?php if ($editMode == true) { ?>
            $('#frmSave :input').attr('disabled', true);
            $('#editBtn').removeAttr('disabled');
            $('#btnBack').removeAttr('disabled');
<?php } ?>
        //Validate the form
        $("#frmSave").validate({

            rules: {

                txtName: { required: true,noSpecialCharsOnly: true, maxlength:50 },
                txtNamesi: { maxlength:50 ,noSpecialCharsOnly: true},
                txtNameta: { maxlength:50 ,noSpecialCharsOnly: true}
            },
            messages: {
                txtName: { required:"<?php echo __("This field is required.") ?>",maxlength:"<?php echo __("Maximum 50 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>" },
                txtNamesi: { maxlength:"<?php echo __("Maximum 50 Characters") ?>", noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"  },
                txtNameta: { maxlength:"<?php echo __("Maximum 50 Characters") ?>", noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>"  }
            }
        });

                              
        // When click edit button
        $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

        $("#editBtn").click(function() {

            var editMode = $("#frmSave").data('edit');
            if (editMode == 1) {
                // Set lock = 1 when requesting a table lock

                location.href="<?php echo url_for('promotion/updatePromotioncklist?id=' . $PromotionCkecklist->getPrm_checklist_id() . '&lock=1') ?>";
            }
            else {

                $('#frmSave').submit();
            }


        });

        //When Click back button
        $("#btnBack").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/promotion/promotioncklist')) ?>";
        });

        //When click reset buton
        $("#btnClear").click(function() {
            // Set lock = 0 when resetting table lock
            location.href="<?php echo url_for('promotion/updatePromotioncklist?id=' . $PromotionCkecklist->getPrm_checklist_id() . '&lock=0') ?>";
        });


    });
</script>
