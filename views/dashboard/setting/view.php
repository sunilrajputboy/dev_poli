<?php
$data = $userDatass;
if (isset($_SESSION['selectid']) && $_SESSION['selectid'] != null) {
    // $ClientData = $obj->ClientData($_SESSION['selectid'], $conn);
    $ClientDatas = $mthis->model->getClientsById($_SESSION['selectid']);
    $ClientData = $ClientDatas[0];
}

$errorMsg = "No company selected !!";

if (isset($_SESSION['selectid']) && $_SESSION['selectid'] != null) {
    $cid = $_SESSION['selectid'];
    $getsingleclient = $mthis->model->getClientsById($cid);
    foreach ($getsingleclient as $sclient) {
        if ($sclient['is_suspended'] != 0) {
            unset($_SESSION['selectid']);
        }
    }
}

?>

<div class="dashboard">
    <div class="page-header-wrap">
        <h3>Settings</h3>
    </div>
    <ul class="nav nav-pills custom-tabs">
        <li id="profile" onclick="mytabFun('profile','#2a')">
            <a href="#2a" class="custom-tab-child" data-toggle="tab">Edit Profile</a>
        </li>
        <li id="company" class="" onclick="mytabFun('company','#1a')">
            <a href="#1a" class="custom-tab-child" data-toggle="tab">Edit Company</a>
        </li>
        <li id="globle_edit" class="" onclick="mytabFun('globle_edit','#3a')">
            <a href="#3a" class="custom-tab-child" data-toggle="tab">global Setting </a>
        </li>
    </ul>
    <div class="tab-content clearfix">
        <div class="tab-pane" id="2a">
            <div class="clear">
                <div class="widget" id="clientSetting">
                    <div class="table-area">
                        <div class="addpackages">
                            <form action="Javascript:void(0)" id="updateuserProfile" method="post">
                                <div class="project-dtails form-group">
                                    <div class="widget-title">
                                        <div class="alert alert-success" id="sucessclientMessage" style="display:none">
                                            <p id="suc_clientmsg"></p>
                                        </div>
                                        <div class="alert alert-danger" id="errorMessage" style="display:none">
                                            <p id="err_msg"></p>
                                        </div>
                                    </div>
                                    <div class="message"></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Name</label>
                                                <input type="text" class="form-control <?php if ($data['name'] != null) {
                                                                                            echo 'value-filled';
                                                                                        } ?> required" name="uname" id="name" placeholder="Name" value="<?php echo $data['name']; ?>">
                                                <span class="error">Name is required</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Phone</label>
                                                <input type="text" class="form-control <?php if ($data['phone'] != null) {
                                                                                            echo 'value-filled';
                                                                                        } ?>" name="uphone" id="phone" placeholder="Phone" value="<?php echo $data['phone']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="uemail" class="form-control <?php if ($data['email'] != null) {
                                                                                                echo 'value-filled';
                                                                                            } ?>" name="email" id="email" placeholder="Email" value="<?php echo $data['email']; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pro-heading">
                                        <h4>Create New Password</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">New Password</label>
                                                <input type="password" class="form-control is_password" name="password" id="password" placeholder="Password">
                                                <span class="error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Confirm password</label>
                                                <input type="password" class="form-control is_password" name="cpassword" id="cpassword" placeholder="Confirm password">
                                                <span class="error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="uid" value="<?php echo $data['id']; ?>" />
                                <div class="text-center">
                                    <button type="submit" name="update" value="update" id="updateUserProfileBtn" class="btn cus-btn">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- Panel Content -->
            </div>
        </div>
        <div class="tab-pane" id="1a">
            <div class="clear">
                <div class="widget">
                    <div class="table-area">
                        <div class="widget-title">
                            <div class="alert alert-success" id="sucessMessage" style="display:none">
                                <button class="close-btn">x</button>
                                <p id="suc_msg"></p>
                            </div>
                            <div class="alert alert-danger" id="errorMessage" style="display:none">
                                <button class="close-btn">x</button>
                                <p id="err_msg"></p>
                            </div>
                        </div>
                        <div class="addpackages">
                            <?php if (isset($_SESSION['selectid']) && $_SESSION['selectid'] != null) { ?>
                                <form action="javascript:void(0)" id="updateCompanyForm" method="post">
                                    <div class="project-dtails form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Company name</label>
                                                    <input type="text" class="form-control required <?php if ($ClientData['name'] != null) {
                                                                                                        echo 'value-filled';
                                                                                                    } ?>" name="cname" id="name" placeholder="Name" value="<?php echo $ClientData['name']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Comapany phone</label>
                                                    <input type="text" class="form-control <?php if ($ClientData['phone'] != null) {
                                                                                                echo 'value-filled';
                                                                                            } ?>" name="cphone" id="phone" placeholder="Phone" value="<?php echo $ClientData['phone']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Comapany email</label>
                                                    <input type="email" class="form-control is_email required <?php if ($ClientData['email'] != null) {
                                                                                                                    echo 'value-filled';
                                                                                                                } ?>" name="cemail" id="email" placeholder="Company email" value="<?php echo $ClientData['email']; ?>">
                                                </div>
                                            </div>
                                            <?php
                                            // $PackageList = $obj->selectAllData('packages', "visibility = 1"); 
                                            $PackageList = $mthis->model->getAllpackages();
                                            ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Select Package</label>
                                                    <select class="form-control <?php if ($ClientData['package'] != null) {
                                                                                    echo 'value-filled';
                                                                                } ?>" name="package" disabled>
                                                        <?php if (!empty($PackageList)) {
                                                            foreach ($PackageList as $row) { ?>
                                                                <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $ClientData['package']) {
                                                                                                                echo 'selected';
                                                                                                            } ?>> <?php echo $row['name']; ?> </option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="cid" value="<?php echo $_SESSION['selectid']; ?>" />
                                    <div class="text-center">
                                        <button type="submit" name="update" id="updateCompanyDetailbtn" value="update" class="btn cus-btn">Update</button>
                                    </div>
                                </form>
                            <?php  } else { ?>
                                <div class="message"></div>
                                <div class="ClientData" style="display:none">
                                    <ul class="company">
                                        <li class="active">Company</li>
                                        <?php

                                        $userData = $userDatass;
                                        $companyData = $userData['clients'];
                                        if ($companyData != null) {
                                            $ids = implode(",", unserialize($companyData));
                                        } else {
                                            $ids = null;
                                        }


                                        $alldataclient = $mthis->model->getClientWhereIn($ids);

                                        if (!empty($alldataclient) && count($alldataclient) == 1) {

                                            foreach ($alldataclient as $ClientData) {
                                                if ($ClientData['is_suspended'] != 1) {
                                                    $_SESSION['selectid'] = $ClientData['id'];
                                                } else {
                                                    unset($_SESSION['selectid']);
                                                    $errorMsg = "Company is suspended !!";
                                                }
                                        ?>
                                                <li style="" class="<?php if ($_SESSION['selectid'] == $ClientData['id']) {
                                                                        echo 'active';
                                                                    } ?>"><?php echo $ClientData['name']; ?></li>
                                        <?php }
                                        } ?>
                                        <?php ?>
                                    </ul>
                                </div>
                                <?php
                                if (!empty($alldataclient) && count($alldataclient) > 1) { ?>
                                    <div class="select-c-box">
                                        <div class="form-group">
                                            <label> Select your company </label>
                                            <select class="form-control" onchange="selectCompany(this)">
                                                <option value="0">Select your company</option>
                                                <?php $selectid = isset($_SESSION['selectid']) ? $_SESSION['selectid'] : '';
                                                foreach ($alldataclient as $ClientData) { ?>
                                                    <option value="<?php echo $ClientData['id']; ?>" <?php if ($ClientData['id'] == $selectid) {
                                                                                                            echo 'selected';
                                                                                                        } ?>><?php echo $ClientData['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php
                                echo '<div class="no-select-box"><div class="no-select-box-inr"><img src="/uploads/no-selected.svg" alt=""><h1>' . $errorMsg . '</h1></div></div>';
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="3a">
            <div class="clear">
                <div class="widget" id="clientSetting">
                    <div class="table-area">
                        <div class="addpackages">
                            <form action="<?php echo BASE_URL; ?>setting/updateglobalsetting" id="clientSettingUpdateForm" method="post" enctype='multipart/form-data'>
                                <input type="hidden" name="unique_url" id="" value="<?php echo $ClientData['unique_url']; ?>">
                                <?php if ( $packageData['is_logo'] != 'no') { ?>
                                <div class="project-dtails form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Upload Logo or enter URL</label>

                                                <div class="custom-checkbox">
                                                    <input type="checkbox" onclick="enablelogourl(this)" name="url" id="logourl" class="" value="yes" <?php if ($ClientData['logo'] != null) {
                                                                                                                                                            echo 'checked';
                                                                                                                                                        } ?>>
                                                    <label for="logourl">Enter url</label>
                                                </div>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" onclick="enablelogofile(this)" name="file" id="logofile" class="" value="yes" <?php if ($ClientData['logofile'] != null) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                    <label for="logofile">Logo</label>
                                                </div>
                                                <div id="url" style="<?php if ($ClientData['logo'] == null) {
                                                                            echo 'display:none';
                                                                        } ?>">
                                                    <input type="text" class="form-control <?php if ($ClientData['logo'] != null) {
                                                                                                echo 'value-filled';
                                                                                            } ?>" name="logourl" id="logo" placeholder="logo URL" value="<?php echo $ClientData['logo']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group" id="chooselogo" style="<?php if ($ClientData['logofile'] == null) {
                                                                                                echo 'display:none';
                                                                                            } ?>">
                                                <div class="custom-file custom-file-1">
                                                    <input type="file" class="custom-file-input form-control m-t-10 <?php if ($ClientData['logofile'] != null) {
                                                                                                                        echo 'value-filled';
                                                                                                                    } ?>" name="logofile" id="logo" placeholder="logo" value="<?php echo $ClientData['logofile']; ?>">
                                                    <label class="custom-file-label" for="logo" data-js-label>Choose file</label>
                                                </div>
                                            </div>
                                            <div class="form-group selected-logo">
                                                <?php
                                                if ($ClientData['logo'] != '') { ?>
                                                    <img src="<?php echo $ClientData['logo'];  ?>" class="data-value" />

                                                <?php } else if ($ClientData['logofile'] != null) {
                                                ?>
                                                    <img src="<?php echo '/uploads/' . $ClientData['logofile'];  ?>" class="data-value" />
                                                <?php
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <!--option foreach-->
								<?php if ($packageData['is_fonts'] != 'no') { ?>

                                <div class="project-dtails form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Select fonts</label>
                                                <select class="form-control" name="fonts" id="fonts">
                                                    <option value="" disabled <?php if ($ClientData['font'] == null) {
                                                                                    echo 'selected';
                                                                                } ?>>Select fonts</option>
                                                    <?php foreach ($fonts as $font) { ?>
                                                        <option value="<?php echo $font['font_family']; ?>" <?php if ($ClientData['font'] != null) {
                                                                                                                if ($ClientData['font'] == $font['font_family']) {
                                                                                                                    echo 'selected';
                                                                                                                }
                                                                                                            } ?>><?php echo $font['font_family']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>

                                <div class="project-dtails form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Select primary color</label>
                                                <div class="colorBox">
                                                    <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $ClientData['primary_color']; ?>" />
                                                    <input type="color" class="colorInput" name="colorprime" onchange="colorChange(this)" id="colors" value="<?php echo $ClientData['primary_color']; ?>" />

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Select secondary color</label>
                                                <div class="colorBox">
                                                    <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $ClientData['secondary_color']; ?>" />
                                                    <input type="color" class="colorInput" name="colorsecond" onchange="colorChange(this)" id="colors" value="<?php echo $ClientData['secondary_color']; ?>" />

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Select text color 1</label>
                                                <div class="colorBox">
                                                    <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $ClientData['text_color']; ?>" />
                                                    <input type="color" class="colorInput" name="text_color" onchange="colorChange(this)" id="colors" value="<?php echo $ClientData['text_color']; ?>" />

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Select text color 2</label>
                                                <div class="colorBox">
                                                    <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $ClientData['text_color2']; ?>" />
                                                    <input type="color" class="colorInput" name="text_color2" onchange="colorChange(this)" id="colors" value="<?php echo $ClientData['text_color2']; ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Select text color 3</label>
                                                <div class="colorBox">
                                                    <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $ClientData['text_color3']; ?>" />
                                                    <input type="color" class="colorInput" name="text_color3" onchange="colorChange(this)" id="colors" value="<?php echo $ClientData['text_color3']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="project-dtails form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group radio-g-m">
                                                <div class="radio-g">
                                                    <input type="radio" id="color_type_2" name="color_type" value="2" checked />
                                                    <label for="color_type_2">Normal colour</label>
                                                </div>
                                                <div class="radio-g">
                                                    <input type="radio" id="color_type_1" name="color_type" value="1" />
                                                    <label for="color_type_1">Colour mixer</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div id="color_type1">
                                                <div class="range-sliders">
                                                    <input class="inputmixer range-slider__range" type="range" id="numsteps" value="<?php if ($ClientData['colours'] != '') {
                                                                                                                                        echo count(unserialize($ClientData['colours'])) - 2;
                                                                                                                                    } else {
                                                                                                                                        echo 1;
                                                                                                                                    } ?>" min="1" max="8" />
                                                    <span class="range-slider__value"></span>
                                                </div>
                                                <br>
                                                <ul class="ulmixer" id="list">
                                                    <?php
                                                    if ($ClientData['colours'] != null) {
                                                        $count = 0;
                                                        foreach (unserialize($ClientData['colours']) as $color) {
                                                            $count++;

                                                            if ($count == 1) {
                                                    ?>
                                                                <li class="limixer" id="start"><input class="inputmobile" type="color" name="colorinput[]" value="<?php echo $color; ?>" size="7" /><span class="spanmixer"></span></li>
                                                            <?php }
                                                            if ($count != 1 && ($count != count(unserialize($ClientData['colours'])))) { ?>
                                                                <li class="interim"><span class="spanmixer"><?php echo $color; ?></span><input type="hidden" class="colorInput" name="colorinput[]" value="<?php echo $color; ?>" /></li>
                                                            <?php }
                                                            if ($count == count(unserialize($ClientData['colours']))) { ?>
                                                                <li class="limixer" id="end"><input class="inputmobile" type="color" name="colorinput[]" value="<?php echo $color; ?>" size="7" /><span class="spanmixer"></span></li>
                                                        <?php
                                                            }
                                                        }
                                                    } else { ?>
                                                        <li class="limixer" id="start"><input class="inputmobile" type="color" name="colorinput[]" value="#5E4FA2" size="7" /><span class="spanmixer"></span></li>
                                                        <li class="limixer" id="end"><input class="inputmobile" type="color" name="colorinput[]" value="#F79459" size="7" /><span class="spanmixer"></span></li>
                                                    <?php
                                                    }
                                                    ?>
                                                </ul>
                                                <br>
                                                <div class="form-group radio-g-m r-none">
                                                    <div class="radio-g">
                                                        <input type="radio" name="intype" value="interpolateColor" id="rgb" checked />
                                                        <label for="rgb">RGB</label>
                                                    </div>
                                                    <div class="radio-g">
                                                        <input type="radio" name="intype" value="interpolateHSL" id="hsl" />
                                                        <label for="hsl">HSL</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="color_type2">
                                                <div class="color-append-box">
                                                    <label for="">Key colors:</label>
                                                    <?php
                                                    if ($ClientData['colours'] != null) {
                                                        $count = 0;
                                                        foreach (unserialize($ClientData['colours']) as $color) {
                                                            $count++;
                                                    ?>
                                                            <div class="colorBox">
                                                                <label for="">Key color <?php echo $count; ?></label>
                                                                <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $color; ?>" />
                                                                <input type="color" class="colorInput" name="color[]" onchange="colorChange(this)" id="colors" value="<?php echo $color; ?>" />
                                                                <?php if ($count == count(unserialize($ClientData['colours']))) { ?>
                                                                    <button class="removeBox" onclick="removeColor(this)">
                                                                        <img src="../images/close.png" alt="">
                                                                    </button>
                                                                <?php } ?>
                                                            </div>
                                                    <?php }
                                                    } ?>
                                                </div>
                                                <div class="m-5" id="addBtnBox" style="<?php if ($count < 10) { ?>display:block<?php } else {
                                                                                                                                echo 'display:none';
                                                                                                                            } ?>">
                                                    <button type="button" class="btn register-link" id="addColorBtn" onclick="addColor()">Add color</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<?php if ($packageData['email_mp'] != 'no' || $packageData['is_charts'] != 'no' || $packageData['is_social_share'] != 'no' || $packageData['is_tweet_mp'] != 'no' || $packageData['is_email_share'] != 'no') { ?>

                                <div class="project-dtails form-group">
                                    <div class="row">
                                    <?php ?>
												<?php if ($packageData['email_mp'] != 'no') { ?>
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <div class="toggleWrapper m-l-0">
                                                    <label for="">Enable Email MP</label>
                                                    <input type="checkbox" name="is_email_mp" onclick="emailMp(this)" id="email_mp" class="dn" value="yes" <?php
                                                                                                                                                            if ($ClientData['is_mp'] != null) {
                                                                                                                                                                if ($ClientData['is_mp'] == 'yes') {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                }
                                                                                                                                                            } ?> />
                                                    <label for="email_mp" class="toggle"><span class="toggle__handler"></span></label>
                                                </div>
                                            </div>
                                            <div id="emailMpsetting" style="<?php if ($ClientData['is_mp'] != null) {
                                                                                if ($ClientData['is_mp'] != 'yes') {
                                                                                    echo 'display:none';
                                                                                }
                                                                            } ?>">
                                                <?php if ($ClientData['email_setting'] != null) {
                                                    $emailSettingArr = unserialize($ClientData['email_setting']);
                                                    $sub = $emailSettingArr['esubject'];
                                                    $msg =   $emailSettingArr['emsg'];
                                                } else {
                                                    $sub = '';
                                                    $msg = '';
                                                } ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Enter email subject</label>
                                                            <input type="text" class="form-control" name="email_sub" id="email_sub" placeholder="Enter email subject" value="<?php echo $ClientData['email_sub'];
                                                                                                                                                                                ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Message</label>
                                                            <textarea class="form-control" name="message" id="msg"><?php echo $ClientData['message']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }  if ($packageData['is_charts'] != 'no') {  ?>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="toggleWrapper m-l-0">
                                                    <label for="">Enable Charts</label>
                                                    <input type="checkbox" name="is_charts" id="charts" class="dn" value="yes" <?php if (isset($ClientData['is_charts']) && $ClientData['is_charts'] != null) {
                                                                                                                                    if ($ClientData['is_charts'] == 'yes') {
                                                                                                                                        echo 'checked';
                                                                                                                                    }
                                                                                                                                } ?> />
                                                    <label for="charts" class="toggle"><span class="toggle__handler"></span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        }
											if ($packageData['is_social_share'] != 'no') {

                                        ?>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="toggleWrapper m-l-0">
                                                    <label for="">Enable social share</label>
                                                    <input type="checkbox" name="is_social_share" onclick="enableSocialShare(this)" id="is_social" class="dn" value="yes" <?php if (isset($ClientData['is_social_share']) && $ClientData['is_social_share'] != null) {
                                                                                                                                                                                if ($ClientData['is_social_share'] == 'yes') {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                }
                                                                                                                                                                            } ?> />
                                                    <label for="is_social" class="toggle"><span class="toggle__handler"></span></label>
                                                </div>
                                            </div>
                                            <div id="socialshareSetting" style="<?php if (isset($ClientData['is_social_share']) && $ClientData['is_social_share'] != null) {
                                                                                    if ($ClientData['is_social_share'] != 'yes') {
                                                                                        echo 'display:none';
                                                                                    }
                                                                                } ?>">
                                                <?php if (isset($ClientData['social_setting']) && $ClientData['social_setting'] != null) {
                                                    $emailSettingArr = unserialize($ClientData['social_setting']);
                                                }  ?>
                                                <div class="row">
                                                    <?php ?>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="custom-checkbox">
                                                                    <input type="checkbox" onclick="enableFacebook(this)" name="facebook" id="is_facebook" class="" value="yes" <?php if (isset($ClientData['is_facebook']) && $ClientData['is_facebook'] != 'no') {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                } ?>>
                                                                    <label for="is_facebook">Facebook</label>
                                                                </div>
                                                                <input type="text" name="is_facebook" class="form-control share-text <?php if (isset($ClientData['is_facebook']) && $ClientData['is_facebook'] != null) {
                                                                                                                                            echo 'value-filled';
                                                                                                                                        } ?>" style="<?php if (isset($ClientData['is_facebook']) && $ClientData['is_facebook'] == 'no') {
                                                                                                                                                            echo 'display:none';
                                                                                                                                                        } ?>" id="is_fb_share" placeholder="Enter share text" value="<?php echo $ClientData['is_facebook']; ?>">
                                                            </div>
                                                        </div>
                                                    <?php ?>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="custom-checkbox">
                                                                <input type="checkbox" onclick="enableInstagram(this)" name="insta" id="is_insta" class="" value="yes" <?php if (isset($ClientData['is_insta']) && $ClientData['is_insta'] != 'no') {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label for="is_insta">Instagram</label>
                                                            </div>
                                                            <input type="text" name="is_insta" class="form-control share-text <?php if (isset($ClientData['is_insta']) && $ClientData['is_insta'] != null) {
                                                                                                                                    echo 'value-filled';
                                                                                                                                } ?>" style="<?php if (isset($ClientData['is_insta']) && $ClientData['is_insta'] == 'no') {
                                                                                                                                                    echo 'display:none';
                                                                                                                                                } ?>" id="is_insta_share" placeholder="Enter share text" value="<?php echo $ClientData['is_insta']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="custom-checkbox">
                                                                <input type="checkbox" onclick="enableTwitter(this)" name="twitter" id="is_twitter" class="" value="yes" <?php if (isset($ClientData['is_twitter']) && $ClientData['is_twitter'] != 'no') {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            } ?>>
                                                                <label for="is_twitter">Twitter</label>
                                                            </div>
                                                            <input type="text" name="is_twitter" class="form-control share-text <?php if (isset($ClientData['is_twitter']) && $ClientData['is_twitter'] != null) {
                                                                                                                                    echo 'value-filled';
                                                                                                                                } ?>" style="<?php if (isset($ClientData['is_twitter']) && $ClientData['is_twitter'] == 'no') {
                                                                                                                                                    echo 'display:none';
                                                                                                                                                } ?>" id="is_twitter_share" placeholder="Enter share text" value="<?php echo $ClientData['is_twitter']; ?>">
                                                        </div>
                                                    </div>
                                                    <?php ?>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="custom-checkbox">
                                                                <input type="checkbox" onclick="enableLinkedin(this)" name="linkedin" id="is_linkedin" class="" value="yes" <?php if (isset($ClientData['is_linkedin']) && $ClientData['is_linkedin'] != 'no') {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            } ?>>
                                                                <label for="is_linkedin">Linkedin</label>
                                                            </div>
                                                            <input type="text" name="is_linkedin" class="form-control share-text <?php if (isset($ClientData['is_linkedin']) && $ClientData['is_linkedin'] != null) {
                                                                                                                                        echo 'value-filled';
                                                                                                                                    } ?>" style="<?php if ($ClientData['is_linkedin'] == 'no') {
                                                                                                                                                        echo 'display:none';
                                                                                                                                                    } ?>" id="is_linkedin_share" placeholder="Enter share text" value="<?php echo $ClientData['is_linkedin']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="custom-checkbox">
                                                            <input type="checkbox" onclick="enableemailfriend(this)" name="is_email_friend" id="is_email_friend" class="" value="yes" <?php if (isset($ClientData['is_email_friend']) &&  $ClientData['is_email_friend'] != 'no') {
                                                                                                                                                                                            echo 'checked';                                                                                                                                                                                     } ?>>
                                                            <label for="is_email_friend">Email a friend</label>
                                                        </div>
                                                        <div class="row" id="emailfriend" style="<?php if (isset($ClientData['is_email_friend']) && $ClientData['is_email_friend'] == 'no') {
                                                                                                        echo 'display:none';
                                                                                                    } ?>">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Title</label>
                                                                    <input type="text" name="email_friend_title" placeholder="Enter title here" id="email_friend_title" class="form-control share-text" value="<?php echo $ClientData['email_friend_title']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="email_friend_text">Message</label>
                                                                    <textarea placeholder="Enter message here" id="email_friend_text" class="form-control tweet-mp-text" name="email_friend_text"><?php echo $ClientData['email_friend_text']; ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            }
																if ($packageData['is_tweet_mp'] != 'no') { ?>

                                        
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="toggleWrapper m-l-0">
                                                            <label for="">Enable tweet MP</label>
                                                            <input type="checkbox" name="is_tweet_mp" onclick="enabletweetMP(this)" id="tweet_mp" class="dn" value="yes" <?php if ($ClientData['is_tweet_mp'] != null) {
                                                                                                                                                                                if ($ClientData['is_tweet_mp'] == 'yes') {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                }
                                                                                                                                                                            } ?> />
                                                            <label for="tweet_mp" class="toggle"><span class="toggle__handler"></span></label>
                                                        </div>
                                                    </div>
                                                    <div id="tweetMptext" style="<?php if ($ClientData['is_tweet_mp'] == 'no') {
                                                                                        echo 'display:none';
                                                                                    } ?>">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="tweetMptext">Mp tweet text</label>
                                                                    <textarea name="tweet_mp_text" id="" placeholder="Write MP tweet text" class="form-control tweet-mp-text <?php if ($ClientData['tweet_mp_text'] != null) {
                                                                                                                                                                                    echo 'value-filled';
                                                                                                                                                                                } ?>"><?php echo $ClientData['tweet_mp_text']; ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
												
                                                    } 
                                                    if ($packageData['is_email_share'] != 'no') {
                                        ?>
                                        <div class="col-md-12" style="display:none;">
                                            <div class="form-group">
                                                <div class="toggleWrapper m-l-0">
                                                    <label for="">Enable email share</label>
                                                    <input type="checkbox" name="is_email_share" id="email_share" class="dn" value="yes" <?php if ($ClientData['is_email_share'] != null) {
                                                                                                                                                if ($ClientData['is_email_share'] == 'yes') {
                                                                                                                                                    echo 'checked';
                                                                                                                                                }
                                                                                                                                            } ?> />
                                                    <label for="email_share" class="toggle"><span class="toggle__handler"></span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>
                                <input type="hidden" name="old_logo_file" value="<?php echo $ClientData['logofile']; ?>" />
                                <input type="hidden" name="id" value="<?php echo $ClientData['id']; ?>" />
                                <div class="text-center">
                                    <button type="submit" id="globalsettingbtn" name="update" value="update" class="btn cus-btn">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- Panel Content -->
            </div>
        </div>
    </div>
</div>
<script>
    localStorage.setItem('tabid', '#2a');
    localStorage.setItem('activetab', 'profile');
</script>