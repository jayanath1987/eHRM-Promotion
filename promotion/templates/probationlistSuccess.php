<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>

<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Probationers") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="" onsubmit="return checkValue();">
            <input type="hidden" name="mode" value="search">
            <div class="searchbox">
                <label for="searchMode"><?php echo __("Search By") ?></label>


                <select name="searchMode" id="searchMode">
                    <option value="all"><?php echo __("--Select--") ?></option>

                    <option value="emp_name" ><?php echo __("Employee Name") ?></option>
                    <option value="app_letter" ><?php echo __("Appointment Letter number") ?></option>
                    <option value="start_date" ><?php echo __("Probation Start Date") ?></option>
                    <option value="end_date" ><?php echo __("Probation End Date") ?></option>
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
            <div class="noresultsbar"></div>
            <div class="pagingbar"><?php echo is_object($pglay) ? $pglay->display() : ''; ?> </div>
            <br class="clear" />
        </div>
        <br class="clear" />
        <form name="standardView" id="standardView" method="post" action="<?php echo url_for('promotion/DeletePromotioncklist') ?>">
            <input type="hidden" name="mode" id="mode" value="" />
            <table cellpadding="0" cellspacing="0" class="data-table">
                <thead>
                    <tr>

                        <td scope="col">

                            <?php if ($culture == 'en') {
                                $btname = 'r.emp_display_name';
                            } else {
                                $btname = 'r.emp_display_name' . $culture;
                            } ?>
<?php echo $sorter->sortLink($btname, __('Employee Name'), '@Probationlist', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                            <?php echo $sorter->sortLink('r.emp_app_letter_no', __('Employee ID'), '@Probationlist', ESC_RAW); ?>

                        </td>
                        <td scope="col">
                            <?php //echo $sorter->sortLink('r.emp_prob_from_date', __('Probation Start Date'), '@Probationlist', ESC_RAW); ?>

                            <?php echo  __('Designation'); ?>
                        </td>
                        <td scope="col">
                            <?php //echo $sorter->sortLink('r.emp_prob_to_date', __('Probation End Date'), '@Probationlist', ESC_RAW); ?>
                            <?php echo __('Division'); ?>
                        </td>
                        <td scope="col">
<?php echo __('Check List'); ?>

                        </td>
                    </tr>
                </thead>

                <tbody>
                    <?php
                            $row = 0;
                            foreach ($listreasons as $reasons) {
                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                $row = $row + 1;
                    ?>
                        <tr class="<?php echo $cssClass ?>" >
                            <td class="" width="200">
                            <?php if ($Culture == 'en') {
                                    $abc = "getEmp_display_name";
                                } else {
                                    $abc = "getEmp_display_name_" . $Culture;
                                }
                            ?>
                            <?php
                                $dd = $reasons->$abc();
                                $rest = substr($reasons->$abc(), 0, 100);

                                if ($reasons->$abc() == null) {
                                    $dd = $reasons->getEmp_display_name();
                                    $rest = substr($reasons->getEmp_display_name(), 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                    } else {
                                        echo $rest;
                                    }
                                } else {

                                    if (strlen($dd) > 100) {
                                        echo $rest
                            ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                    } else {
                                        echo $rest;
                                    }
                                }
                            ?>
                            </td>
                            <td class="" width="150">
                            <?php echo $reasons->employeeId; ?>
                            </td>
                            <td class="" width="100">
                            <?php
                                if ($Culture == 'en') {
                                    $dd = $reasons->jobTitle->getJobtit_name();
                                    $rest = substr($reasons->jobTitle->getJobtit_name(), 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest ?>.<span title="<?php echo $dd ?>">...</span><?php
                                    } else {
                                        echo $rest;
                                    }
                                } else {
                                    $abc = 'getJobtit_name_' . $Culture;
                                    $dd = $reasons->jobTitle->$abc();
                                    $rest = substr($reasons->jobTitle->$abc(), 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest ?>..<span title="<?php echo $dd ?>">...</span><?php
                                    } else {
                                        echo $rest;
                                    }
                                    if ($reasons->jobTitle->$abc() == null) {
                                        $dd = $reasons->jobTitle->getJobtit_name();
                                        $rest = substr($reasons->jobTitle->getJobtit_name(), 0, 100);
                                        if (strlen($dd) > 100) {
                                            echo $rest ?>..<span title="<?php echo $dd ?>">...</span><?php
                                        } else {
                                            echo $rest;
                                        }
                                    }
                                }
                            ?>
                            </td>
                            <td class="" width="100">
                            <?php     
                            if ($Culture == 'en') {
                                    $dd = $reasons->subDivision->title;
                                    $rest = substr($reasons->subDivision->title, 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest ?>.<span title="<?php echo $dd ?>">...</span><?php
                                    } else {
                                        echo $rest;
                                    }
                                } else {
                                    $abc = 'title_' . $Culture;
                                    $dd = $reasons->subDivision->$abc;
                                    $rest = substr($reasons->subDivision->$abc, 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest ?>.<span title="<?php echo $dd ?>">...</span><?php
                                    } else {
                                        echo $rest;
                                    }
                                    if ($reasons->subDivision->$abc == null) {
                                        $dd = $reasons->subDivision->title;
                                        $rest = substr($reasons->subDivision->title, 0, 100);
                                        if (strlen($dd) > 100) {
                                            echo $rest ?>.<span title="<?php echo $dd ?>">...</span> <?php
                                        } else {
                                            echo $rest;
                                        }
                                    }
                                } ?>
                            </td>
                            <td class="" width="100">
                                <a href="<?php echo url_for('promotion/checklist?id='); ?><?php echo $reasons->getEmp_number() ?>"><?php echo __("Checklist"); ?> </a>
                                    </td>


                                </tr>
<?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <script type="text/javascript">
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
            function checkValue(){
                if($("#searchValue").val()==""){
                    alert("<?php echo __('Please enter search value') ?>");
                    return false;

                }
                if($("#searchMode").val()=="all"){
                    alert("<?php echo __('Please select the search mode') ?>");
                    return false;
                }
                else{
                    $("#frmSearchBox").submit();
                }}
            $(document).ready(function() {

                buttonSecurityCommon(null,null,"editBtn",null);

                //When click add button
                $("#buttonAdd").click(function() {
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/promotion/savePromotioncklist')) ?>";

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
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/promotion/probationlist')) ?>";
        });


    });


</script>
