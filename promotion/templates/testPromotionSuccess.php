<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>

<div class="outerbox" >
    <div class="maincontent">

        <div class="mainHeading" ><h2><?php echo __("Promotion  Summary") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="" onsubmit="return checkValue();">
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
                    <option value="emp_display_name_" <?php
                            if ($searchMode == 'emp_display_name_') {
                                echo "selected";
                            }
        ?>><?php echo __("Employer Name") ?></option>

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
            <div class="actionbuttons">

                <input type="button" class="plainbtn" id="buttonAdd"
                       value="<?php echo __("Add") ?>" />


                <input type="button" class="plainbtn" id="buttonRemove"
                       value="<?php echo __("Delete") ?>" />

            </div>
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

                            <input type="checkbox" class="checkbox" name="allCheck" value="" id="allCheck" />

                        </td>


                        <td scope="col">
                            <?php
                            if ($culture == 'en') {
                                $btname = 'e.emp_display_name';
                            } else {
                                $btname = 'e.emp_display_name_' . $culture;
                            }
                            ?>
                            <?php echo $sorter->sortLink($btname, __('Employee Name'), '@Promotion', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                            <?php
                            if ($culture == 'en') {
                                $btname = 's.service_name';
                            } else {
                                $btname = 's.service_name_' . $culture;
                            } ?>
                            <?php echo $sorter->sortLink($btname, __('New Service'), '@Promotion', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                            <?php
                            if ($culture == 'en') {
                                $btname = 'j.jobtit_name';
                            } else {
                                $btname = 'j.jobtit_name_' . $culture;
                            } ?>
                            <?php echo $sorter->sortLink($btname, __('Designation'), '@Promotion', ESC_RAW); ?>
                        </td>
                        <td scope="col">                            
                            <?php
                            if ($culture == 'en') {
                                $btname = 'emp.name';
                            } else {
                                $btname = 'emp.estat_name_' . $culture;
                            }
                            ?>
                            <?php echo $sorter->sortLink($btname, __('Emp.Type'), '@Promotion', ESC_RAW); ?>
                        </td>
                        <td scope="col">
                            <?php echo $sorter->sortLink('p.prm_effective_date', __('Efc.Date'), '@Promotion', ESC_RAW); ?>
                        </td>

                        <td scope="col">
                            <?php
                            if ($culture == 'en') {
                                $btname = 'pm.prm_method_comment_en';
                            } else {
                                $btname = 'pm.prm_method_comment_' . $culture;
                            }
                            ?>
                            <?php echo $sorter->sortLink($btname, __('Prm.Method'), '@Promotion', ESC_RAW); ?>
                        </td>
                        <td scope="col" width="50">
                            <?php echo __('P.Letter') ?>
                        </td>
                        <td scope="col" >
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
                                        <input type='checkbox' class='checkbox innercheckbox' name='chkLocID[]' id="chkLoc" value='<?php echo $promotion->getPrm_id() ?>' />
                                    </td>


                            
                            <td class="" width="90"><a href="<?php echo url_for('promotion/savePromotion?update=yes&id=' . $promotion->prm_id) ?>">
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
                                ?></a>
                            </td>
                            <td class="" width="90">
                            <?php
                                if ($culture == 'en') {
                                    $dd = $promotion->ServiceDetails->getService_name();
                                    $rest = substr($promotion->ServiceDetails->getService_name(), 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest ?>.<span title="<?php echo $dd ?>">...</span><?php
                                    } else {
                                        echo $rest;
                                    }
                                } else {
                                    $abc = 'getService_name_' . $culture;
                                    $dd = $promotion->ServiceDetails->$abc();
                                    $rest = substr($promotion->ServiceDetails->$abc(), 0, 100);
                                    if (strlen($dd) > 100) {
                                        echo $rest ?>.<span title="<?php echo $dd ?>">...</span><?php
                                    } else {
                                        echo $rest;
                                    }
                                    if ($promotion->ServiceDetails->$abc() == null) {
                                        $dd = $promotion->ServiceDetails->getService_name();
                                        $rest = substr($promotion->ServiceDetails->getService_name(), 0, 100);
                                        if (strlen($dd) > 100) {
                                            echo $rest ?>.<span title="<?php echo $dd ?>">...</span> <?php
                                        } else {
                                            echo $rest;
                                        }
                                    }
                                } ?>
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
                }
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
                //When click add button
                $("#buttonAdd").click(function() {
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/promotion/savePromotion')) ?>";

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
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/promotion/listPromotion')) ?>";
        });

	  	
    });


</script>

