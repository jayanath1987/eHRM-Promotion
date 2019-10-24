<?php
if ($lockMode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>
<link href="../../themes/orange/css/style.css" rel="stylesheet" type="text/css"/>
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
        <div class="mainHeading"><h2><?php echo __("Edit Promotion") ?></h2></div>
        <form name="frmSave" id="frmSave" method="post"  action="" enctype="multipart/form-data">
<?php echo message() ?>
            <?php echo $form['_csrf_token']; ?>
            <?php $abc = $culture; ?>
            <!-- 1 -->


            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Letter Number") ?> </label> </div>

            <div class="centerCol"> <input type="text" value="<?php echo $listPromotion->getPrm_my_number() ?>"  name="txtMyNumber" id="txtLetterID" readonly="true" maxlength="50"/> </div>
            <br class="clear"/>

            <!-- 2 -->
            <div class="leftCol">
                <label  class="controlLabel" for="txtLocationCode"><?php echo __("Employee Name") ?></label></div>
            <div class="centerCol"><input type="text" name="txtEmployeeName" readonly="readonly"
                                          id="txtEmployee" value="<?php echo $listPromotion->Employee->getLastName(); ?>" /></div>
            <input type="hidden" name="txtEmpId" id="txtEmpId" value="<?php echo $listPromotion->getEmp_number() ?>"/>&nbsp;
<!--             <input class="button" type="button" value="..." id="empRepPopBtn" <?php echo $disabled; ?> />-->
            <br class="clear"/>

            <!--2.2 -->
            <div class="leftCol">      <label class="controlLabel" for="txtLocationCode"><?php echo __("New Service") ?></label> </div>
            <div class="centerCol"><select name="txtNewservice"  style="width: 150px;" >

<?php foreach ($promotionsev as $promotionftype) {
?>
                    <option value="<?php echo $promotionftype->getService_code(); ?>" <?php if ($promotionftype->getService_code() == $listPromotion->getService_code())
                        echo"selected"; ?>><?php
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
            <span class="formValue"><input type="hidden" value="<?php echo $listPromotion->getService_code() ?>" class="formInputText" name="txtMyNumber" id="txtLetterID"  /></span>
                <br class="clear"/>



                <!-- 3 -->
                <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Grade:") ?> </label></div>
                <!--    <input type="text" value="" class="formInputText" " name="txtcgrd" id="txtE" />-->
                <div class="centerCol"><select name="txtngrd"  style="width: 150px;">
<?php foreach ($promotiona as $promotionl) {
?>
                            <option value="<?php echo $promotionl->getGrade_code(); ?>" <?php if ($promotionl->getGrade_code() == $listPromotion->getGrade_code())
                                echo"selected"; ?>><?php
                            if ($culture == 'en') {
                                $abcd = "getGrade_name";
                            } else {
                                $abcd = "getGrade_name_" . $culture;
                            }
                            if ($promotionl->$abcd() == "") {
                                echo $promotionl->getGrade_name();
                            } else {
                                echo $promotionl->$abcd();
                            }
?></option>

<?php } ?>

                </select></div>
            <span class="formValue"><input type="hidden" value="<?php echo $listPromotion->getGrade_code() ?>" class="formInputText"  name="txtngrd1" id="txtLetterID"  /></span>
                <br class="clear"/>

                <!-- 4 -->
                <div class="leftCol"> <label class="controlLabel" for="transfertypecombo"><?php echo __("Designation") ?></label></div>

                <div class="centerCol"><select name="txtndesg"  style="width: 150px;">

<?php foreach ($promotiondesc as $promotionfdesc) {
?>
                            <option value="<?php echo $promotionfdesc->getJobtit_code(); ?>" <?php if ($promotionfdesc->getJobtit_code() == $listPromotion->getJobtit_code())
                                echo"selected"; ?>><?php
                            if ($culture == 'en') {
                                $abcd = "getJobtit_name";
                            } else {
                                $abcd = "getJobtit_name_" . $culture;
                            }
                            if ($promotionfdesc->$abcd() == "") {
                                echo $promotionfdesc->getJobtit_name();
                            } else {
                                echo $promotionfdesc->$abcd();
                            } ?></option>
                        <?php } ?>
                </select></div>
            <span class="formValue"><input type="hidden" value="<?php echo $listPromotion->getJobtit_code() ?>" class="formInputText" name="txtndesg1" id="txtLetterID"  /></span>
                <br class="clear"/>
                <!-- 5 -->
                <div class="leftCol"><label class="controlLabel" for="transfertypecombo"><?php echo __("Employee Type") ?></label></div>

                <div class="centerCol"><select name="txtnetype"  style="width: 150px;">

                    <?php foreach ($promotionemptype as $promotionfet) {
                    ?>
                            <option value="<?php echo $promotionfet->getEstat_code(); ?>" <?php if ($promotionfet->getEstat_code() == $listPromotion->getEstat_code())
                                echo"selected"; ?>><?php
                            if ($culture == 'en') {
                                $abcd = "getEstat_name";
                            } else {
                                $abcd = "getEstat_name_" . $culture;
                            }
                            if ($promotionfet->$abcd() == "") {
                                echo $promotionfet->getEstat_name();
                            } else {
                                echo $promotionfet->$abcd();
                            }
                    ?></option>
                    <?php } ?>
                    </select></div>
                <span class="formValue"><input type="hidden" value="<?php echo $listPromotion->getEstat_code() ?>" class="formInputText" name="txtnetype1" id="txtLetterID"  /></span>
                <br class="clear"/>
                <!-- 6 -->

                <!-- 7 -->
                <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Effective Date") ?><span class="required">*</span> </label></div>
                <div class="centerCol"><input placeholder="<?php echo $dateDisplayHint; ?>"  id="effdate" type="text" name="effdate" value="<?php echo LocaleUtil::getInstance()->formatDate($listPromotion->getPrm_effective_date()) ?>"></div>
                <div style="display: none;" class="demo-description"></div>
                <br class="clear"/>

                <!-- 8 -->
                <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Location") ?> </label></div>
                <div class="centerCol"><input id="datepicke" type="text" name="txtLocation" value="<?php echo $listPromotion->getPrm_location() ?>" maxlength="100"></div>
                <div style="display: none;" class="demo-description"></div>
                <br class="clear"/>

                <!-- 9 -->
                <div class="leftCol"> <label class="controlLabel" for="txtLocationCode"><?php echo __("Salary Code") ?> </label></div>
                <div class="centerCol"><input id="datepicer" type="text" name="txtSalary" value="<?php echo $listPromotion->getPrm_sal_code() ?>" maxlength="20"></div>

                <br class="clear"/>
                <div class="leftCol">
                    <label class="controlLabel" for="txtLocationCode"><?php echo __("Salary Scale") ?> </label></div>
                <div class="centerCol"><input id="txtSalaryScale" type="text" name="txtSalaryScale" value="<?php echo $listPromotion->getPrm_salary_scale() ?>" maxlength="20"></div>

                <div style="display: none;" class="demo-description"></div>
                <br class="clear"/>

                <!-- 10 --> <?php $cult = getPrm_method_comment_ . $culture; //echo($cult);die;     ?>
                <div class="leftCol"><label class="controlLabel" for="txtLocationCode"><?php echo __("Promotion Method") ?><span class="required">*</span></label></div>
                <div class="centerCol"><select name="txtprmmethod"  style="width: 150px;">
                        <option value="-1"><?php echo __("--Select--") ?></option>
                    <?php foreach ($promotionMethod as $promotionftype) {
 ?>
                            <option value="<?php echo $promotionftype->getPrm_method_id(); ?>" <?php if ($promotionftype->getPrm_method_id() == $listPromotion->getPrm_method_id())
                                echo"selected"; ?>><?php
                                if ($promotionftype->$cult() == null) {
                                    echo $promotionftype->getPrm_method_comment_en();
                                } else {
                                    echo $promotionftype->$cult();
                                }
                    ?></option>
                        <?php } ?>
                </select></div>
            <span class="formValue"><input type="hidden" value="<?php echo $listPromotion->getService_code() ?>" class="formInputText" name="txtMyNumber" id="txtLetterID"  /></span>
                <br class="clear"/>

                <!-- 11 -->

                    <div class="leftCol"><label  class="controlLabel" for="txtLocationCode" ><?php echo __("Upload Promotion Letter") ?> </label></div>
                    <div class="centerCol"><INPUT TYPE="file" class="formInputText" VALUE="Upload" name="txtletter" style="margin-left: 0px;"/></div>
                <?php if (!$editMode or $conf == 1) {
                ?><label style="margin-left :80px;"><a href="#" onclick="popupimage(link='<?php echo url_for('promotion/imagepop?id='); ?><?php echo $listPromotion->getPrm_id(); ?>')"><?php
                                $kk = $prm->readattach($listPromotion->getPrm_id());
                                foreach ($kk as $rowa) {
                                    if ($rowa['count'] == 1) {
                                        echo __("View");
                                    }
                                }
                ?></a>  <a id="deletelink" onclick="return deletelink();"  href="<?php echo url_for('promotion/deletepop?id='); ?><?php echo $listPromotion->getPrm_id() ?>"> <?php
                                $kk = $prm->readattach($listPromotion->getPrm_id());
                                foreach ($kk as $rowa) {
                                    if ($rowa['count'] == 1) {
                                        echo __("Delete");
                                    }
                                }
                ?> </a></label> <?php } ?>
                <br class="clear"/>

                <!--12 -->
                <div class="leftCol"> <label class="controlLabel" for="txtLocationCode"><?php echo __("Comment") ?> </label></div>
                <div class="centerCol"><textarea style="margin-left: 0px;" class="formTextArea" name="comment" type="text" ><?php echo $listPromotion->prm_comment; ?></textarea></div>
                <?php $max = $PromotionCkecklistmax[0]['count']; ?>


            <!--13 -->

            <br class="clear"/>
        </form>
        <br class="clear"/>

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
                     <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
                <br class="clear" />
            </div>

<?php
                        require_once '../../lib/common/LocaleUtil.php';
                        $sysConf = OrangeConfig::getInstance()->getSysConf();
                        $sysConf = new sysConf();
                        $inputDate = $sysConf->dateInputHint;
                        $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());

//$format=$sysConf->dateFormat;
?>

                        <script type="text/javascript">
                            function popupimage(link){
                                window.open(link, "myWindow",
                                "status = 1, height = 300, width = 300, resizable = 0" )
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

                                function popupimage(link){
                                    window.open(link, "myWindow","status = 1, height = 300, width = 300, resizable = 0" )
                                }


                           
                            $(document).ready(function() {

                                $("#datepicker").placeholder();
                                buttonSecurityCommon(null,null,"editBtn",null);

<?php if ($editMode == true) { ?>
                            $('#frmSave :input').attr('disabled', true);
                            $('#editBtn').removeAttr('disabled');
                            $('#btnBack').removeAttr('disabled');
<?php } ?>

<?php if ($conf == 1) { ?>
                            $('#frmSave :input').attr('disabled', true);
                            $('#editBtn').removeAttr('disabled', true);
                            $('#btnBack').removeAttr('disabled');
                            //$('#editBtn').attr('disabled', true);
                            $('#editBtn').hide();
                            $('#btnClear').hide();
<?php } ?>
                        jQuery.validator.addMethod("orange_date",
                        function(value, element, params) {

                        var format = params[0];

                        // date is not required
                        if (value == '') {

                        return true;
                        }
                        var d = strToDate(value, "<?php echo $format ?>");


                        return (d != false);

                        }, ""
                        );

                        $("#datepicker").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });

                        $('#empRepPopBtn').click(function() {
                        var popup=window.open('<?php echo public_path('../../templates/hrfunct/emppop.php?reqcode=REP&promo2=1'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');
                        if(!popup.opener) popup.opener=self;
                        popup.focus();
                        });


                        //Validate the form
                        $("#frmSave").validate({

                        rules: {
                        txtMyNumber:{ noSpecialCharsOnly: true,maxlength:50  },
                        txtName: { required: true },
                        txtprmconmethod: { required: true },
                        effdate: { required: true ,orange_date:true},
                        comment: { noSpecialCharsOnly: true, maxlength:200 },
                        dhcomment: { noSpecialCharsOnly: true, maxlength:200 },
                        txtSalaryScale: { maxlength:20 },
                        txtSalary: { noSpecialCharsOnly: true, maxlength:20 }
                        },
                        messages: {
                        txtName: "<?php echo __("Job Title Name is required") ?>",
                        txtprmconmethod: "<?php echo __("Please Select Confirm Method") ?>",
                        txtSalary: {maxlength:"<?php echo __("Maximum 50 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>" },
                        txtSalaryScale: {maxlength:"<?php echo __("Maximum 20 Characters") ?>" },
                        effdate: {required:"<?php echo __("Please Enter Date") ?>",orange_date:"<?php echo __("Please specify valid date") ?>" },
                        comment: {maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>" },
                        dhcomment: {maxlength:"<?php echo __("Maximum 200 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>" },
                        txtMyNumber:{ maxlength:"<?php echo __("Maximum 50 Characters") ?>",noSpecialCharsOnly:"<?php echo __("Special Characters are not allowed") ?>" }

                        }
                        });


                        // When click edit button
                        $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                        $("#editBtn").click(function() {

                        var editMode = $("#frmSave").data('edit');
                        if (editMode == 1) {
                        // Set lock = 1 when requesting a table lock
                        var con =  "<?php echo $con ?>";
                        if(con == 1){
                        location.href="<?php echo url_for('promotion/updatePromotion?id=' . $listPromotion->getPrm_id() . '&lock=1&con=1') ?>";
                        }
                        else{
                        location.href="<?php echo url_for('promotion/updatePromotion?id=' . $listPromotion->getPrm_id() . '&lock=1') ?>";
                        }
                        }
                        else {

                        $('#frmSave').submit();
                        }


                        });

                        //When Click back button
                        $("#btnBack").click(function() {
                        location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/promotion/listPromotion')) ?>";
                        });

                        //When click reset buton
                        $("#btnClear").click(function() {
                        // Set lock = 0 when resetting table lock
<?php if ($con == 1) { ?>
                            location.href="<?php echo url_for('promotion/updatePromotion?id=' . $listPromotion->getPrm_id() . '&lock=0&con=1') ?>";
<?php } else { ?>
                            location.href="<?php echo url_for('promotion/updatePromotion?id=' . $listPromotion->getPrm_id() . '&lock=0') ?>";
<?php } ?>
                        });


                        });
                        function returnLocDet(){

                        // TODO: Point to converted location popup
                        var popup=window.open('<?php echo public_path('../../symfony/web/index.php/admin/listCompanyStructure?mode=select_subunit&method=mymethod1'); ?>','Locations','height=450,resizable=1,scrollbars=1');
if(!popup.opener) popup.opener=self;
}
function mymethod1($id,$name){


$("#cmbLocation").val($id);
$("#txtLocation").val($name);

}
</script>
