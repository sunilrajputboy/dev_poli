<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Projects extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checkLoggedIn();
    }
    function index()
    {
        $userId = $_SESSION['uid'];
        $result = $this->model->getUserDetailsById($userId);
        $userDatass = $result[0];
        define("USERROLE", $userDatass['role']);

        if (USERROLE == 1) {
            $gid = isset($_SESSION['groupid']) ? $_SESSION['groupid'] : 0;
            if (isset($_GET['id'])) {
                $cidGet = $_GET['id'];
            } else {
                $cidGet = null;
            }
            if (isset($_SESSION['projectArray'])) {
                if ($_SESSION['projectArray'] != 'NO') {
                    $projectids = implode(',', $_SESSION['projectArray']);
                    $projectArray = $projectids;
                } else {
                    $projectArray = '0';
                }
            }
            if (isset($_SESSION['projectArray'])) {
                $result = $this->model->getProjectWhereIn($projectArray);
            } else if ($cidGet != null) {
                $result = $this->model->getProjectByClientId($cidGet);
            } else {
                $result = $this->model->getAllProjects();
            }
            $allClients = $this->model->getAllClients();
            $allProjectGroups = $this->model->getAllProjectGroups();
            $userdetails = array('projects' => $result, 'allClients' => $allClients, 'userDatass' => $userDatass, 'gid' => $gid, 'allProjectGroups' => $allProjectGroups, 'mthis' => $this);
            $this->view->mydashboard('dashboard/projects/view_admin', false, $userdetails);
        } else {
            $projectArray = array();
            $userData = $userDatass;
            $companyData = $userData['clients'];
            if ($companyData != null) {
                $ids = implode(",", unserialize($companyData));
            } else {
                $ids = null;
            }
            $alldataclient = $this->model->getClientWhereIn($ids);
            if (!empty($alldataclient)) {
                foreach ($alldataclient as $clientData) {
                    if ($clientData['is_suspended'] != 1) {
                        $_SESSION['cid'] = $clientData['id'];
                    } else {
                        unset($_SESSION['cid']);
                    }
                }
            }
            if ($_SESSION['cid'] != null) {
                $cid = $_SESSION['cid'];
                $getsingleclient = $this->model->getClientsById($cid);
                foreach ($getsingleclient as $sclient) {
                    if ($sclient['is_suspended'] != 0) {
                        unset($_SESSION['cid']);
                    }
                }
            }
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $QueryClientResult = $this->model->getClientsById($cid);
                if (!empty($QueryClientResult)) {
                    $Queryrow = $QueryClientResult[0];
                    $projectArray = unserialize($Queryrow['projects']);
                    $projectArray = implode(',', $projectArray);
                }
            }
            $gid = isset($_SESSION['groupid']) ? $_SESSION['groupid'] : null;
            if (isset($_SESSION['projectArray'])) {
                if ($_SESSION['projectArray'] != 'NO') {
                    $projectids = implode(',', $_SESSION['projectArray']);
                    $projectArray = $projectids;
                } else {
                    $projectArray = '';
                }
            }
            $userdetails = array('alldataclient' => $alldataclient, 'userDatass' => $userDatass, 'gid' => $gid, 'mthis' => $this, 'projectArray' => $projectArray);
            $this->view->mydashboard('dashboard/projects/view', false, $userdetails);
        }
    }

    function add()
    {
        $userId = $_SESSION['uid'];
        $result = $this->model->getUserDetailsById($userId);
        $userDatass = $result[0];
        define("USERROLE", $userDatass['role']);
        $clients = $this->model->getAllClients();
        // 		$cid = isset($_SESSION['cid']) ? $_SESSION['cid'] : null;
        $cid = isset($_SESSION['selectid']) ? $_SESSION['selectid'] : $_SESSION['cid'];
        $clientsdata = $this->model->getClientsById($cid);
        $cdata = !empty($clientsdata) ? $clientsdata[0] : array();
        if (!empty($cdata)) {
            $packageData = $this->model->getPackageById($cdata['package']);
        } else {
            $packageData = array();
        }
        $pdata = !empty($packageData) ? $packageData[0] : array();

        $projectData = $this->model->getProjectByClientId($cid);
		/************/
		$allMaptemplateCategory=$this->model->getMapTemplateCategory();
	   $mapTemplates=array();
	   $cat_array=array();
	   if(!empty($allMaptemplateCategory)){
		   foreach($allMaptemplateCategory as $cat){
			   $cat_array['category_name']=$cat['category_name'];
			   $allMaptemplates=$this->model->getMapTemplatesByCategory($cat['id']);
			   $cat_array['template_list']=!empty($allMaptemplates) ? $allMaptemplates : array();
			   $mapTemplates[]=$cat_array;
		   }
	   }
		/*************/
        $userdetails = array('userDatass' => $userDatass, 'clients' => $clients, 'mthis' => $this, 'cdata' => $cdata, 'pdata' => $pdata, 'projectData' => !empty($projectData) ? $projectData : array(), 'map_templates' => $mapTemplates);
        if (USERROLE == 1) {
            $this->view->mydashboard('dashboard/projects/add_admin', false, $userdetails);
        } else {
            $this->view->mydashboard('dashboard/projects/add', false, $userdetails);
            // header('Location:'. BASE_URL.'dashboard');
        }
    }

    function addprojects()
    {
        if ($_POST['pname']) {
            $userId = $_SESSION['uid'];
            $result = $this->model->getUserDetailsById($userId);
            $userDatass = $result[0];
            define("USERROLE", $userDatass['role']);
            if (USERROLE == 1) {
                $idclient = $_POST['cid'];
            } else {
                $idclient = isset($_SESSION['selectid']) ? $_SESSION['selectid'] : $_SESSION['cid'];
            }
            $pname = $_POST['pname'];
            $added_by = $_SESSION['uid'];
            $map = $_POST['map'];
            $is_charts = 'no';
            $is_socialshare = 'no';
            $is_email_mp = 'no';
            $title = $_POST['pname'];
            $url = str_replace('-', ' ', $pname);
            $unique_url =  strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9 ]/', '', $url)));

            $ckeckuniquelike = $this->model->checkUniqueUrllike($unique_url, $idclient);

            $uarr = [];
            if (!empty($ckeckuniquelike)) {
                foreach ($ckeckuniquelike as $url) {
                    $uarr[] = str_replace('-', '', filter_var($url['unique_url'], FILTER_SANITIZE_NUMBER_INT));
                }

                $unique_url = $unique_url . (max($uarr) + 1);
            }


            $allTemplate = $this->model->addprojects($pname, $map, $title, $idclient, $is_email_mp, $is_charts, $is_socialshare, $added_by, $unique_url);
            $_SESSION["success_msg"] = 'Project added successfully';
            echo  json_encode(array('success' => 1, 'msg' => 'Project added.', 'redirect_url' => BASE_URL . 'projects/viewprojects/' . $allTemplate));
        } else {
            $_SESSION["error_msg"] = 'Unknown method';
            echo  json_encode(array('success' => 0, 'msg' => 'Unknown method.', 'redirect_url' => BASE_URL . 'projects'));
        }
    }

    function edit($userId)
    {
        $userIds = $_SESSION['uid'];
        $result = $this->model->getUserDetailsById($userIds);
        $userDatass = $result[0];
        define("USERROLE", $userDatass['role']);
        $clients = $this->model->getClients();
        $userdata = $this->model->getUserDetailsById($userId);
        $data = !empty($userdata) ? $userdata[0] : array();
        $userdetails = array('userDatass' => $userDatass, 'data' => $data, 'clients' => $clients, 'mthis' => $this);
        $this->view->mydashboard('dashboard/projects/edit', false, $userdetails);
    }

    function delete($projectId)
    {
        $delete = $this->model->deleteProject($projectId);
        $_SESSION["success_msg"] = 'Project deleted successfully.';
        header('Location:' . BASE_URL . 'projects/');
    }
    function viewprojects($pId)
    {
        $key = 'Hl2018@1212';
        $projectId = openssl_decrypt(hex2bin($pId), 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        $userIds = $_SESSION['uid'];
        $result = $this->model->getUserDetailsById($userIds);
        $userDatass = $result[0];
        define("USERROLE", $userDatass['role']);
        $projectdata = $this->model->getProjectById($projectId);
        $dataFieldsData = $this->model->getDataFieldsById($projectId);
        $dataFieldsDataWithoutGroup = $this->model->getDataFieldsByIdWithoutGroup($projectId);
        $datafieldsWithoutChild = $this->model->datafieldsWithoutChild($projectId);
        $chartWizard = $this->model->getchartWizard($projectId);
        $allTemplate = $this->model->getAllTemplate();
        $allFonts = $this->model->getAllFonts();
        $main_details = array('userDatass' => $userDatass, 'projectData' => $projectdata, 'dataFieldsData' => $dataFieldsData, 'dataFieldsDataWithoutGroup' => $dataFieldsDataWithoutGroup, 'mthis' => $this, 'key' => $key, 'pId' => $pId, 'projectId' => $projectId, 'datafieldsWithoutChild' => $datafieldsWithoutChild, 'chartWizard' => $chartWizard, 'allTemplate' => $allTemplate, 'allFonts' => $allFonts);
        $this->view->mydashboard('dashboard/projects/viewprojects', false, $main_details);
    }

    function update_general()
    {
        if (isset($_POST['unique_update'])) {
            $project_id = $_POST['project_id'];
            $unique_url = $_POST['unique_url'];
            $allTemplate = $this->model->updateGeneral($unique_url, $project_id);
            $_SESSION["success_msg"] = 'project updated successfully.';
?>
            <script>
                window.history.back();
            </script>
        <?php
        } else {
            $_SESSION["error_msg"] = 'Unknown method.';
        }
    }
    function hideprojects($proId)
    {

        if ($proId) {
            $allTemplate = $this->model->hideprojects($proId);
        ?>
            <?php
            $_SESSION["success_msg"] = 'Project drafted successfully.';
            ?>
            <script>
                window.history.back();
            </script>
        <?php
        }
    }
    function showprojects($proId)
    {

        if ($proId) {
            $allTemplate = $this->model->showprojects($proId);
        ?>
            <?php
            $_SESSION["success_msg"] = 'Project publish successfully.';
            ?>
            <script>
                window.history.back();
            </script>
        <?php
        }
    }
    function lock($proId)
    {
        if ($proId) {
            $allTemplate = $this->model->lockprojects($proId);
        ?>
            <?php
            $_SESSION["success_msg"] = 'Project lock successfully.';
            ?>
            <script>
                window.history.back();
            </script>
        <?php
        }
    }
    function unlock($proId)
    {
        if ($proId) {
            $allTemplate = $this->model->unlockprojects($proId);
        ?>
            <?php
            $_SESSION["success_msg"] = 'Project unlock successfully.';
            ?>
            <script>
                window.history.back();
            </script>
        <?php
        }
    }



    function update()
    {
        $id = $_POST['id'];
        $pname = $_POST['name'];
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $email_mp = isset($_POST['is_email_mp']) ? $_POST['is_email_mp'] : null;
        $charts = isset($_POST['is_charts']) ? $_POST['is_charts'] : null;
        $is_social_share = isset($_POST['is_social_share']) ? $_POST['is_social_share'] : null;
        $is_email_share = isset($_POST['is_email_share']) ? $_POST['is_email_share'] : null;
        $is_tweet_mp = isset($_POST['is_tweet_mp']) ? $_POST['is_tweet_mp'] : null;

        $colorsecond = isset($_POST['colorsecond']) ? $_POST['colorsecond'] : '';
        $colorprime = isset($_POST['colorprime']) ? $_POST['colorprime'] : '';
        $text_color = isset($_POST['text_color']) ? $_POST['text_color'] : '';
        $text_color2 = isset($_POST['text_color2']) ? $_POST['text_color2'] : '';
        $text_color3 = isset($_POST['text_color3']) ? $_POST['text_color3'] : '';
        if (isset($_POST['url']) && $_POST['url'] == 'yes') {
            $logourl = $_POST['logourl'];
            $logo = null;
        } else {
            $logourl = null;
        }
        $logo = $_POST['old_logo_name'];

        if (isset($_POST['file']) && $_POST['file'] == 'yes') {
            if ($_FILES["logo"]["name"] == NULL) {
                $logo = $_POST['old_logo_name'];
            } else {
                $ext = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
                $logo = rand() . '.' . $ext;
                move_uploaded_file($_FILES["logo"]["tmp_name"], "uploads/" . $logo);
                $logourl = null;
            }
        }

        if (isset($_POST['is_email_mp']) && $_POST['is_email_mp'] == null) {
            $email_mp = 'no';
        }
        if (isset($_POST['is_charts']) && $_POST['is_charts'] == null) {
            $charts = 'no';
        }
        if (isset($_POST['is_social_share']) && $_POST['is_social_share'] == null) {
            $is_social_share = 'no';
        }
        if (isset($_POST['is_email_share']) && $_POST['is_email_share'] == null) {
            $is_email_share = 'no';
        }
        if (isset($_POST['is_tweet_mp']) && $_POST['is_tweet_mp'] == null) {
            $is_tweet_mp = 'no';
        }

        $title = $_POST['title'];
        if ($title == null) {
            $title = $pname;
        }
        if (isset($_POST['fonts']) && $_POST['fonts'] != null) {
            $fonts  = $_POST['fonts'];
        } else {
            $fonts  = 1;
        }

        $description = $_POST['description'];

        if (isset($_POST['color_type']) && $_POST['color_type'] == 1) {
            if (isset($_POST['colorinput']) && $_POST['colorinput'] != null) {
                $color = serialize($_POST['colorinput']);
            } else {
                $color = null;
            }
        } else {
            if (isset($_POST['color']) && $_POST['color'] != null) {
                $color = serialize($_POST['color']);
            } else {
                $color = null;
            }
        }

        $allTemplate = $this->model->update($pname, $title, $logo, $logourl, $description, $colorprime, $colorsecond, $text_color, $text_color2, $text_color3, $color, $fonts, $email_mp, $charts, $is_social_share, $is_email_share, $is_tweet_mp, $id);
        //print_r($allTemplate);
        //die();
        $_SESSION["success_msg"] = 'Project updated successfully.';

        $key = 'Hl2018@1212';
        $encrypted_id = openssl_encrypt($id, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        $encrypted_id = strtolower(bin2hex($encrypted_id));

        echo  json_encode(array('success' => 1, 'msg' => 'Project updated.', 'redirect_url' => BASE_URL . 'projects/viewprojects/' . $encrypted_id));
    }

    function updateContent()
    {
        $id = $_POST['id'];

        $footer_content = $_POST['footer_content'];
        $node_description = $_POST['node_description'];
        $print_description = $_POST['print_description'];
        $node_intro = $_POST['node_intro'];

        $allTemplate = $this->model->updateContent($footer_content, $node_description,$print_description,$node_intro, $id);
        $_SESSION["success_msg"] = 'Project updated successfully.';

        $key = 'Hl2018@1212';
        $encrypted_id = openssl_encrypt($id, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        $encrypted_id = strtolower(bin2hex($encrypted_id));

        echo  json_encode(array('success' => 1, 'msg' => 'Project updated.', 'redirect_url' => BASE_URL . 'projects/viewprojects/' . $encrypted_id));
    }
    
    
    function updateprivacypolicy(){
        $project_id = $_POST['project_id'];
        $privacypolicy = $_POST['privacypolicy'];
        
        $subscribe_mail_text = $_POST['subscribe_mail_text'];
          $subscribe_mail_address = $_POST['subscribe_mail_address'];
            $copyright_title = $_POST['copyright_title'];
              $copyright_link = $_POST['copyright_link'];
        
        
        $allTemplate = $this->model->updatePrivacypolicyContent($privacypolicy,$subscribe_mail_text,$subscribe_mail_address,$copyright_title, $copyright_link,$project_id);
        $_SESSION["success_msg"] = 'Updated successfully.';
        $key = 'Hl2018@1212';
        $encrypted_id = openssl_encrypt($project_id, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        $encrypted_id = strtolower(bin2hex($encrypted_id));
        ?>
        <script>
             location.href = '<?php echo BASE_URL; ?>projects/viewprojects/<?php echo $encrypted_id; ?>';
        </script>
        <?php 
    }
    
    function editProjectname()
    {
        $id = $_POST['id'];
        $pname = $_POST['name'];

        $allTemplate = $this->model->updateProname($pname, $id);
        $_SESSION["success_msg"] = 'Project Name updated successfully.';

        $key = 'Hl2018@1212';
        $encrypted_id = openssl_encrypt($id, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        $encrypted_id = strtolower(bin2hex($encrypted_id));

        echo  json_encode(array('success' => 1, 'msg' => 'Project updated.', 'redirect_url' => BASE_URL . 'projects/viewprojects/' . $encrypted_id));
    }


    function add_chart()
    {
        $cname = $_POST['cname'];
        $graphfor = $_POST['graphfor'];
        $graph_type = $_POST['graph_type'];
        $fieldData = $_POST['selectedFields'];
        $mapWidth = $_POST['map_width'];
        $pro_id = $_POST['pro_id'];

        $c_displayname = $_POST['c_displayname'];
        $x_axis = $_POST['x_axis'];
        $y_axis = $_POST['y_axis'];

        if ($fieldData != null) {
            $fieldData = serialize($fieldData);
        }
        $field_color = $_POST['field_color'];
 $average_color = $_POST['average_color'];
        if ($field_color != null) {
            $field_color = serialize($field_color);
        }

        $hide_average = isset($_POST['hide_average']) ? $_POST['hide_average'] : null;

        if (isset($_POST['hide_average']) && $_POST['hide_average'] == null) {
            $hide_average = 'no';
        }

        $allTemplate = $this->model->addChart($cname, $c_displayname, $x_axis, $y_axis, $graphfor, $hide_average, $graph_type, $fieldData,$field_color,$average_color, $mapWidth, $pro_id);
        // $_SESSION["success_msg"]='Chart Wizard created successfully.';

        echo  json_encode(
            array(
                'success' => 1,
                'msg' => 'Chart Wizard created successfully.',
                'redirect_url' => $_SERVER['HTTP_REFERER']
            )
        );
    }
    function update_chart()
    {

        $cname = $_POST['cname'];
        $graphfor = $_POST['graphfor'];
        $graph_type = $_POST['graph_type'];
        $fieldData = $_POST['selectedFields'];
        $mapWidth = $_POST['map_width'];
        $pro_id = $_POST['pro_id'];
        $id = $_POST['id'];

        $chart_displayname = $_POST['chart_displayname'];
        $c_x_axis = $_POST['c_x_axis'];
        $c_y_axis = $_POST['c_y_axis'];

        if ($fieldData != null) {
            $fieldData = serialize($fieldData);
        }
        $field_color = $_POST['field_color'];
          $average_color = $_POST['average_color'];

        if ($field_color != null) {
            $field_color = serialize($field_color);
        }

        $hide_average = isset($_POST['hide_average']) ? $_POST['hide_average'] : null;

        if (isset($_POST['hide_average']) && $_POST['hide_average'] == null) {
            $hide_average = 'no';
        }

        $allTemplate = $this->model->updateChart($cname, $chart_displayname, $c_x_axis, $c_y_axis, $graphfor, $hide_average, $graph_type, $fieldData,$field_color, $average_color, $mapWidth, $id);
        // $_SESSION["success_msg"]='Chart Wizard updated successfully.';

        echo  json_encode(
            array(
                'success' => 1,
                'msg' => 'Chart Wizard updated successfully.',
                'redirect_url' => $_SERVER['HTTP_REFERER']
            )
        );
    }
    function deletechart($id)
    {

        $allTemplate = $this->model->deleteChart($id);
        $_SESSION["success_msg"] = 'Chart deleted successfully.';
        ?>
        <script>
            window.history.back();
        </script>
    <?php

    }
    function getchart()
    {

        $id = $_POST['id'];
        $proid = $_POST['proid'];
        $getChartDataArray = $this->model->getChartData($id);
        $getChartData = $getChartDataArray[0];
        $datafieldsWithoutChild = $this->model->datafieldsWithoutChild($proid);
        $prokey_colors = $this->model->getProKey_colors($proid);
        $prokeycolor = unserialize($prokey_colors[0]['key_colors']);


    ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h5 class="modal-title">Chart wizard</h5>
        </div>
        <div class="modal-body">
            <div class="chart_wizard">
                <form action="javascript:void(0)" id="updateChart" method="post">
                    <div class="form-group">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Chart Name</label>
                                    <input type="text" class="form-control required" name="chart_name" id="cname1" placeholder="Chart name" value="<?php echo $getChartData['name']; ?>">
                                    <span class="error" style="display: none;">Chart name is required</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Display name</label>
                                    <input type="text" class="form-control" name="c_display_name" id="chart_displayname" value="<?php echo $getChartData['display_name']; ?>" placeholder="Chart display name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Horizontal Label</label>
                                    <input type="text" class="form-control" name="c_x_axis" id="c_x_axis" value="<?php echo $getChartData['x_axis']; ?>" placeholder="Chart x axis name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Vertical Label</label>
                                    <input type="text" class="form-control" name="c_y_ayis" id="c_y_axis" value="<?php echo $getChartData['y_axis']; ?>" placeholder="Chart y axis name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Is graph for node or national pages</label>
                                    <div class="graphFor">

                                        <input type="radio" class="form-control" name="graphfor1" id="graphfornodes" value="Node" <?php if ($getChartData['graph_for'] == 'Node') {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?>>
                                        <label for="graphfornodes">Node</label>

                                        <input type="radio" class="form-control" name="graphfor1" id="graphfornationalpages1" value="National" <?php if ($getChartData['graph_for'] == 'National') {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                        <label for="graphfornationalpages1">National</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="toggleWrapper">
                                    <label for="" class="lowercase">Show Average in Node View</label>
                                    <input type="checkbox" name="hide_average1" id="hide_average1" class="dn" value="yes" <?php if ($getChartData['hide_average'] == 'yes') {
                                                                                                                                echo 'checked';
                                                                                                                            } ?> />
                                    <label for="hide_average1" class="toggle"><span class="toggle__handler"></span></label>
                                </div>
                            </div>
                            
                             <div class="col-md-12">
                                                         <div class="form-group">
                                                            <label for="">Average Color</label>
                                                              <div class="colorBoxm">
                                                                <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php  echo isset($getChartData['average_color']) ? $getChartData['average_color'] : '#000000'; ?>">
                                                                <input type="color" class="colorInput" name="average_color" onchange="colorChange(this)" id="average_color1" value="<?php  echo isset($getChartData['average_color']) ? $getChartData['average_color'] : '#000000'; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                            

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">What type of graph do you want to create</label>
                                    <div class="graph_type">
                                        <select id="graph_type1" name="graph_type1" class="form-control">
                                            <option value="Bar" <?php if ($getChartData['graph_type'] == 'Bar') {
                                                                    echo 'selected';
                                                                } ?>>Bar</option>
                                            <option value="Column" <?php if ($getChartData['graph_type'] == 'Column') {
                                                                        echo 'selected';
                                                                    } ?>>Column</option>
                                            <option value="Pie" <?php if ($getChartData['graph_type'] == 'Pie') {
                                                                    echo 'selected';
                                                                } ?>>Pie</option>
                                            <option value="Line" <?php if ($getChartData['graph_type'] == 'Line') {
                                                                        echo 'selected';
                                                                    } ?>>Line</option>
                                            <option value="Donut" <?php if ($getChartData['graph_type'] == 'Donut') {
                                                                        echo 'selected';
                                                                    } ?>>Donut</option>
                                                                      <option value="Simpletable" <?php if ($getChartData['graph_type'] == 'Simpletable') {
                                                                        echo 'selected';
                                                                    } ?>>Simple Table</option>
                                                                    
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="">
                                    <div class="datafields_data">
                                        <div class="row">
											
											
											<div class="equal-height">
                                            <div class="col-md-6 equal-height-node">
                                                <label for="">Select field to display</label>
                                                <div class="droptarget" id="allFacets1">

                                                    <?php
                                                    $datafields = $getChartData['datafields'];
                                                    if ($datafields != null) {
                                                        $datafields = unserialize($datafields);
                                                    } else {
                                                        $datafields = [];
                                                    }

                                                    $field_color = $getChartData['field_color'];
                                                    if ($field_color != null) {
                                                        $field_color = unserialize($field_color);
                                                    } else {
                                                        $field_color = [];
                                                    }

                                                    foreach ($datafieldsWithoutChild as $key => $dparent) {
                                                        if (!in_array($dparent['id_project_field'], $datafields)) {
                                                            if($dparent['isGroup']){ ?>

                                                            <div class="fields-item group-fields-item">
                                                            <input type="text" disabled class="disabled" value="<?php echo $dparent['field_name']; ?>" readonly>
                                                            </div>

                                                            <?php
                                                                $parentId = $dparent['id_project_field'];
                                                                            
                                                            $datafieldsChild = $this->model->getProjectFieldsByParentId($parentId);
                                                            if(!empty($datafieldsChild)){ 
                                                                foreach($datafieldsChild as $dchild){
                                                        if (!in_array($dchild['id_project_field'], $datafields)) {
                                                                    
                                                                    ?>
                                                                <div class="fields-item children">
                                                                <p draggable="true" id="up_<?php echo $dchild['id_project_field']; ?>" class="dfield_name1" value="<?php echo $dchild['id_project_field']; ?>"><?php echo $dchild['field_name']; ?></p>
                                                           <div class="colorBoxm" style="<?php if ($getChartData['graph_type'] == 'Line') { echo 'display:none;';}  ?>">
                                                                <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo isset($prokeycolor[$key]) ? $prokeycolor[$key] : '#000000'; ?>">
                                                                <input type="color" class="colorInput" name="field_color[]" onchange="colorChange(this)" id="colors" value="<?php echo isset($prokeycolor[$key]) ? $prokeycolor[$key] : '#000000'; ?>">
                                                            </div>
                                                           </div>
                                                                    
                                                             <?php  
                                                        }
                                                            }  ?>
                                                    
                                                    <?php  } ?>


                                                          <?php  }else{ 
                                                    ?>
                                                              <div class="fields-item">
                                                           <p draggable="true" id="up_<?php echo $dparent['id_project_field']; ?>" class="dfield_name1" value="<?php echo $dparent['id_project_field']; ?>"><?php echo $dparent['field_name']; ?></p>
                                                           <div class="colorBoxm" style="<?php if ($getChartData['graph_type'] == 'Line') { echo 'display:none;';}  ?>">
                                                                <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo isset($prokeycolor[$key]) ? $prokeycolor[$key] : '#000000'; ?>">
                                                                <input type="color" class="colorInput" name="field_color[]" onchange="colorChange(this)" id="colors" value="<?php echo isset($prokeycolor[$key]) ? $prokeycolor[$key] : '#000000'; ?>">
                                                            </div>
                                                           </div>
                                                    <?php
                                                             } }

                                                    }
                                                    ?>


                                                </div>
                                            </div>
                                            <div class="col-md-6  equal-height-node">
                                                <label for="">Selected</label>
                                                <div class="droptarget" id="selected_fields1">
                                                    <?php
                                                    if ($datafields != null) {
                                                        foreach ($datafields as $key => $did) {
                                                            $getfieldnameArray = $this->model->getDataFieldsByFieldId($did);
                                                            $getfieldname = $getfieldnameArray[0];
                                                    ?>
                                                             <div class="<?php echo ($getfieldname['parentId'] != 0) ? 'fields-item children' : 'fields-item'; ?>">
                                                        <p id="up_<?php echo $did; ?>" class="dfield_name1" value="<?php echo $did; ?>"><?php echo $getfieldname['field_name']; ?></p>
                                                        <div class="colorBoxm" style="<?php if ($getChartData['graph_type'] == 'Line') { echo 'display:none;';}  ?>">
                                                                <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php  echo isset($field_color[$key]) ? $field_color[$key] : (isset($prokeycolor[$key]) ? $prokeycolor[$key] : '#000000'); ?>">
                                                                <input type="color" class="colorInput" name="field_color[]" onchange="colorChange(this)" id="colors" value="<?php  echo isset($field_color[$key]) ? $field_color[$key] : (isset($prokeycolor[$key]) ? $prokeycolor[$key] : '#000000'); ?>">
                                                            </div>
                                                    </div>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
											</div>	
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Chart width</label>
                                    <div class="graphFor radio-g-m">
                                        <div class="radio-g">
                                            <input type="radio" class="form-control" name="mapwidth1" id="mapwidthhalfs" value="half_width" <?php if ($getChartData['map_width'] == 'half_width') {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?>>
                                            <label for="mapwidthhalfs">Half width</label>
                                        </div>
                                        <div class="radio-g">
                                            <input type="radio" class="form-control" name="mapwidth1" id="mapwidthfulls" value="full_width" <?php if ($getChartData['map_width'] == 'full_width') {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?>>
                                            <label for="mapwidthfulls">Full width</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                             
                                                    
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="hidden" class="form-control" name="proid" id="proid" value="<?php echo $proid; ?>">
                        <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $id; ?>">
                        <button type="button" id="updateChartBtn" onclick="updateChart()" name="submit" value="submit" class="btn cus-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }

    function checkunique()
    {
        if (isset($_POST['unique_url'])) {
            $unique_url = $_POST['unique_url'];
            $project_id = $_POST['project_id'];
            $idclient = $_POST['cid'];
            $ckeckunique = $this->model->checkUniqueUrl($unique_url, $project_id, $idclient);
            if (!empty($ckeckunique)) {
                $unique_urlnew = $unique_url . '1';
                $ret = array('status' => 0, 'msg' => 'Sorry, this Unique url already taken. You can use <strong>' . $unique_urlnew . '</strong> instead. ');
            } else {
                $ret = array('status' => 1, 'msg' => 'Unique url available, You can use it.');
            }
            echo json_encode($ret);
        } else {
            $ret = array('status' => 0, 'msg' => 'Wrong request!');
            echo json_encode($ret);
        }
    }
    function updateUniqueUrl()
    {

        $project_id = $_POST['project_id'];
        $unique_url = $_POST['unique_url'];

        $allTemplate = $this->model->updateUniqueUrl($unique_url, $project_id);
        $_SESSION["success_msg"] = 'Unique url updated successfully.';

        $key = 'Hl2018@1212';
        $encrypted_id = openssl_encrypt($project_id, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        $encrypted_id = strtolower(bin2hex($encrypted_id));

        echo  json_encode(array('success' => 1, 'msg' => 'Unique url updated successfully.', 'redirect_url' => BASE_URL . 'projects/viewprojects/' . $encrypted_id));
    }
    function projectstatus()
    {
        if ($_POST['user_ids']) {
            $user_id = $_POST['user_ids'];
            $action = $_POST['action_status'];

            if ($action == 'publish') {
                $password_protected = 0;
                $visibility = 1;
            } else if ($action == 'draft') {
                $password_protected = 0;
                $visibility = 0;
            } else {
                $password_protected = 1;
                $visibility = 1;
            }
            $allTemplate = $this->model->projectstatus($password_protected, $visibility, $user_id);
            if ($allTemplate) {
                echo json_encode(array('success' => 1, 'msg' => 'status updated.'));
            } else {
                echo 'failed';
            }
        } else {
            echo json_encode(array('success' => 0, 'msg' => 'something went wrong!'));
        }
    }
    function addpassword()
    {
        $id = $_POST['id'];
        $key = 'Hl2018@1212';
        $encrypted_pass = openssl_encrypt($_POST['password'], 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        $encrypted_pass = strtolower(bin2hex($encrypted_pass));
        $password = $encrypted_pass;

        $allTemplate = $this->model->addpassword($password, $id);
        $_SESSION["success_msg"] = 'password added successfully.';
        if ($allTemplate) {
            $resultArray = array(
                'success' => 1,
                'msg' => 'Password added successfully.'
            );
            echo json_encode($resultArray);
        }
    }
    
      function update_social_settings()
    {
         if (isset($_POST['update_social_setting'])) {
             
          $is_social_share = isset($_POST['is_social_share']) ? $_POST['is_social_share'] : null;
           if (isset($_POST['is_facebook']) && $_POST['is_facebook'] != 'yes') {
                $is_facebook = 'no';
            } else {
                $is_facebook = isset($_POST['is_facebook']) ? $_POST['is_facebook_text'] : 'no';
            }

            if (isset($_POST['is_insta']) && $_POST['is_insta'] != 'yes') {
                $is_insta = 'no';
            } else {
                $is_insta = isset($_POST['is_insta']) ? $_POST['is_insta_text'] : 'no';
            }

            if (isset($_POST['is_twitter']) && $_POST['is_twitter'] != 'yes') {
                $is_twitter = 'no';
            } else {
                $is_twitter = isset($_POST['is_twitter']) ? $_POST['is_twitter_text'] : 'no';
            }
            if (isset($_POST['is_linkedin']) && $_POST['is_linkedin'] != 'yes') {
                $is_linkedin = 'no';
            } else {
                $is_linkedin = isset($_POST['is_linkedin']) ? $_POST['is_linkedin'] : 'no';
            }
            
            
             $is_tweet_mp = isset($_POST['is_tweet_mp']) ? $_POST['is_tweet_mp'] : null;
               $tweet_mp_text = isset($_POST['tweet_mp_text']) ? $_POST['tweet_mp_text'] : null;
               if (isset($_POST['is_tweet_mp']) && $_POST['is_tweet_mp'] == null) {
                $is_tweet_mp = 'no';
                $tweet_mp_text = null;
            }
            $id = $_POST['id_project'];
            
            // 
            $socialallTemplate = $this->model->update_socialSettings($is_social_share,$is_facebook,$is_insta,$is_twitter,$is_linkedin,$is_tweet_mp,$tweet_mp_text,$id);
         ?>   <script>
            localStorage.setItem("message_success_setting", 'Social setting updated successfully.');
        </script>
        <?php
        $_SESSION["success_msg"] = 'Social setting updated successfully.';
        ?>
        <script>
            window.history.back();
        </script>
        <?php  }
    }

    function update_mail_settings()
    {
            if (isset($_POST['update_mail_setting'])) {
                if (isset($_POST['is_email_friend']) && $_POST['is_email_friend'] != 'yes') {
                    $is_email_friend = 'no';
                } else {
                    $is_email_friend = isset($_POST['is_email_friend']) ? $_POST['is_email_friend'] : 'no';
                }
                $email_friend_title = isset($_POST['email_friend_title']) ? $_POST['email_friend_title'] : null;
                $email_friend_text = isset($_POST['email_friend_text']) ? $_POST['email_friend_text'] : null;
                $emailmp_MH = isset($_POST['emailmp_MH']) ? $_POST['emailmp_MH'] : null;
                $email_sub = isset($_POST['email_sub']) ? $_POST['email_sub'] : null;
                $message = isset($_POST['message']) ? $_POST['message'] : null;
                $email_mp = isset($_POST['is_email_mp']) ? $_POST['is_email_mp'] : null;
                if (!isset($_POST['is_email_mp'])) {
                    $email_mp = 'no';
                    $email_sub = null;
                    $message = null;
                }
                $id = $_POST['id_project'];
                $allTemplate = $this->model->updatemailSettings($is_email_friend,$email_friend_title,$email_friend_text,$emailmp_MH,$email_sub,$message,$email_mp,$id); 
                ?>   <script>
                localStorage.setItem("message_success_setting", 'Mail setting updated successfully.');
            </script>
            <?php
            $_SESSION["success_msg"] = 'Mail setting updated successfully.';
            ?>
            <script>
                window.history.back();
            </script>
            <?php }
    }

    function update_settings()
    {
        if (isset($_POST['update_setting'])) {
            $id = $_POST['id_project'];
            $fonts = isset($_POST['fonts']) ? $_POST['fonts'] : 1;
            $charts = isset($_POST['is_charts']) ? $_POST['is_charts'] : null;
          
            $is_email_share = isset($_POST['is_email_share']) ? $_POST['is_email_share'] : null;
           
          
			/********SUNIL-10-02-2023***********/
            $is_image_export = (isset($_POST['is_image_export']) && $_POST['is_image_export']=='yes') ? 'yes' : 'no';
            $is_pdf_download = (isset($_POST['is_pdf_download']) && $_POST['is_pdf_download']=='yes') ? 'yes' : 'no';
			/********************/

           
            if (isset($_POST['is_charts']) && $_POST['is_charts'] == null) {
                $charts = 'no';
            }
            if (isset($_POST['is_social_share']) && $_POST['is_social_share'] == null) {
                $is_social_share = 'no';
            } else {
                $is_social_share = isset($_POST['is_social_share']) ? $_POST['is_social_share'] : 'no';
            }

            if (isset($_POST['is_email_share']) && $_POST['is_email_share'] == null) {
                $is_email_share = 'no';
            } else {
                $is_email_share =  isset($_POST['is_email_share']) ? $_POST['is_email_share'] : 'no';
            }


         

            if (isset($_POST['is_email_share']) && $_POST['is_email_share'] == null) {
                $is_email_share = 'no';
            }
         
            if (isset($_POST['fonts']) && $_POST['fonts'] == null) {
                $fonts  = 1;
            }

            $hide_node = isset($_POST['hide_node']) ? $_POST['hide_node'] : null;
            if (isset($_POST['hide_node']) && $_POST['hide_node'] == null) {
                $hide_node = 'no';
            }
			$cta_text=$_POST['cta_text'];
			
            $subscribe_mail_text = isset($_POST['subscribe_mail_text']) ? $_POST['subscribe_mail_text'] : null;
            if($subscribe_mail_text == '' || $subscribe_mail_text == ' '){
                $subscribe_mail_text = null;
            }
            	$subscribe_mail_address = isset($_POST['subscribe_mail_address']) ? $_POST['subscribe_mail_address'] : null;
		        $copyright_title = isset($_POST['copyright_title']) ? $_POST['copyright_title'] : null;
		        $copyright_link = isset($_POST['copyright_link']) ? $_POST['copyright_link'] : null;

            $allTemplate = $this->model->updateSettings($fonts, $hide_node, $charts, $is_email_share,$cta_text,$subscribe_mail_text,$subscribe_mail_address,$copyright_title,$copyright_link,$is_pdf_download,$is_image_export,$id); 
 ?>
            <script>
                localStorage.setItem("message_success_setting", 'Settings updated successfully.');
            </script>
            <?php
            $_SESSION["success_msg"] = 'Settings updated successfully.';
            ?>
            <script>
                window.history.back();
            </script>
        <?php
        }
    }
    /*************************/
    function adddatafields()
    {
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $proId = $_POST['id'];
            $type = $_POST['type'];
            $hide_node = isset($_POST['hide_node']) ? $_POST['hide_node'] : null;
            $hide_empty_valu_on_node = isset($_POST['hide_empty_valu_on_node']) ? $_POST['hide_empty_valu_on_node'] : null;
            $mid = $_POST['mid'];
            $displayName = $_POST['display_name'];
            $isGroup = isset($_POST['isGroup']) ? $_POST['isGroup'] : null;
            if ($isGroup != null) {
                $isGroup = $_POST['isGroup'];
            } else {
                $isGroup = '0';
            }
            $dataFieldsData = $this->model->dataFieldsByName($name, $proId);
            if (!empty($dataFieldsData)) {
                echo json_encode(array('success' => 0, 'msg' => 'Name already exists!'));
                exit;
            }
            $myObj = new stdClass;
            $myObj->comparable = isset($_POST['comparable']) ? $_POST['comparable'] : false;
            $myObj->isMultivalued = isset($_POST['multivalued']) ? $_POST['multivalued'] : false;
            $myObj->displayRankings = isset($_POST['node_ranking']) ? $_POST['node_ranking'] : false;
            $myObj->invertRankings = isset($_POST['invert_node_ranking']) ? $_POST['invert_node_ranking'] : false;
            $myObj->groupingMethod = (isset($_POST['grouping']) && $_POST['grouping']) ? $_POST['grouping'] : 'Percentiles';
            $myObj->includeAverageInNodeGraphs = isset($_POST['overall_range']) ? $_POST['overall_range'] : false;
            $myObj->showAverageInDataSetSummary = isset($_POST['override_average']) ? $_POST['override_average'] : false;
            $myObj->averageOverride = isset($_POST['average_override_number']) ? $_POST['average_override_number'] : null;
            $myObj->showChartDatasetSummary = isset($_POST['chart_data_set_summary']) ? $_POST['chart_data_set_summary'] : false;
            $myObj->showTotalInDataSetSummary = isset($_POST['total_data_set_summary']) ? $_POST['total_data_set_summary'] : false;
            $myObj->excludeMinFromDataSetSummaryGraph = isset($_POST['exclude_minimum_data_set_summary']) ? $_POST['exclude_minimum_data_set_summary'] : false;
            $myObj->excludeMaxFromDataSetSummaryGraph = isset($_POST['exclude_maximum_data_set_summary']) ? $_POST['exclude_maximum_data_set_summary'] : false;
            $myObj->excludeAverageFromDataSetSummaryGraph = isset($_POST['exclude_average_data_set_summary']) ? $_POST['exclude_average_data_set_summary'] : false;
            $myObj->graphType = isset($_POST['graphtype']) ? $_POST['graphtype'] : '';
			$myObj->link_text = (isset($_POST['link_text']) && $_POST['link_text']) ? $_POST['link_text'] : '';
			$myObj->map_areas_border_colour = (isset($_POST['map_areas_border_colour']) && $_POST['map_areas_border_colour']) ? $_POST['map_areas_border_colour'] : '';
			$myObj->average_without_empty_nodes = (isset($_POST['average_without_empty_nodes']) && $_POST['average_without_empty_nodes']) ? $_POST['average_without_empty_nodes'] : false;
            $myObj->columns = array(
                'name' => $name,
                'icon' => null,
                'label' => null,
                'columnIndex' => null,
                'averageOverride' => isset($_POST['average_override_number']) ? $_POST['average_override_number'] : 0,
                'displayRankings' => isset($_POST['node_ranking']) ? $_POST['node_ranking'] : false,
                'invertRankings' => isset($_POST['invert_node_ranking']) ? $_POST['invert_node_ranking'] : false,
                'maxValue' => null,
                'minValue' => null,
                'average' => null,
                'totalValue' => null
            );
            $myObj->maxValue = null;
            $myObj->minValue = null;
            $myObj->average = null;
            $myObj->totalValue = null;
            $myJSON = json_encode($myObj);
            $description1 = $description;

            $last_id = $this->model->addDataFields($proId, $name, $displayName, $type, $hide_node, $hide_empty_valu_on_node, $description1, $myJSON, $isGroup);
            $getTemplates = $this->model->getSameMapTemplateRegions($proId);

            if (!empty($getTemplates)) {
                foreach ($getTemplates as $mapData) {
                    $city_id = $mapData['city_id'];
                    $sqlMapInsert = $this->model->insertDataFieldValue($proId, $city_id, $last_id);
                }
            }
            $key = 'Hl2018@1212';
            $encrypted_id = openssl_encrypt($proId, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
            $encrypted_id = strtolower(bin2hex($encrypted_id));
            $_SESSION["success_msg"] = 'Data field added successfully.';
            echo json_encode(array('success' => 1, 'msg' => 'Data inserted successfully.', 'redirect_url' => BASE_URL . 'projects/viewprojects/' . $encrypted_id));
        } else {
            $_SESSION["error_msg"] = 'something went wrong.';
            echo json_encode(array("status" => 400, 'something went wrong.'));
        }
    }
    /*************************/
    function displaynodes()
    {
        if (isset($_POST['mid'])) {
            $mid = $_POST['mid'];
            $pid = $_POST['pid'];
            $is_include_empty_nodes = $_POST['is_include_empty_node'];
            /****
			$projectDetails = $this->model->getProjectById($pid);
			if(!empty($projectDetails)){
				$id_map_template=$projectDetails[0]['id_map_template'];
				$projectMapTemplates = $this->model->mapTemplateRegions($id_map_template);
				  echo "<pre>"; print_r($projectDetails[0]['id_map_template']); echo "</pre>"; 
			}
             *****/
            $dataFieldsDataWithoutGroup = $this->model->getDataFieldsByIdWithoutGroup($pid);

            $nodeDetails = $this->model->getNodeDetails($pid);
            $count = count($dataFieldsDataWithoutGroup);
			//echo "<pre>"; print_r($count); echo "</pre>"; die();
            $nodesarray = array();
            $fieldDataarr = array();
            $fieldValueArray = array();
        ?>
            <table class="table table-striped nodes-table" id="constituencyNodestable">
                <thead>
                    <tr>
                        <th>Country</th>
                        <th style="display:none"></th>
                        <th style="display:none"></th>
             <?php foreach($dataFieldsDataWithoutGroup as $dataf){  ?>
                         <th style="display:none"></th>
             <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(!empty($nodeDetails)) {
                        $i = 0;
                        $tdData = "";
                        foreach ($nodeDetails as $nd) {
                            $f_name = $nd['field_name'];
                            $f_value = $nd['field_value'];
                            $d_id = $nd['data_id'];
                            $i++;
                            if ($is_include_empty_nodes == 'false') {
                                if (!empty($nd['field_value'])) {
                                    $fieldValueArray[] = $nd['field_value'];
                                    $tdData .= '<td style="display:none">' . $f_name . ': <span class="mainFieldValue-' . $d_id . '" id="mainFieldValue-' . $d_id . '">' . $f_value . '</span></td>';
                                } else {
                                    $tdData .= '<td style="display:none"></td>';
                                }
                            } else {
                                $fieldValueArray = array('not_empty');
                                $tdData .= '<td style="display:none">' . $f_name . ': <span class="mainFieldValue-' . $d_id . '" id="mainFieldValue-' . $d_id . '">' . $f_value . '</span></td>';
                            }
                            $fieldDataarr[] = array('field_name' => $nd['field_name'], 'field_value' => $nd['field_value'], 'field_id' => $nd['field_id'], 'data_id' => $nd['data_id']);
                            $f_name = $nd['field_name'];
                            $f_value = $nd['field_value'];
                            $d_id = $nd['data_id'];
  if ($i == $count) {
     $node_arr = array("name" => $nd['name'], "id" => $nd['id'], "data" => $fieldDataarr);
      $i = 0;
      if (!empty($fieldValueArray)){ ?>
		<tr id="id<?php echo $nd['id']; ?>">
			<td class="details-control"><?php echo $nd['name']; ?>
			</td>
			<td style="display:none"><?php echo $nd['id']; ?></td>
			<td style="display:none"><?php echo $pid; ?></td>
			<?php echo $tdData; ?>
		</tr>
 <?php
		$fieldDataarr = array();
		$tdData = '';
		$fieldValueArray = array();
                                }
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
            <script>
                var table2 = $('#constituencyNodestable').DataTable({
                    "DisplayLength": 5,
                    lengthMenu: [
                        [100, 200, -1],
                        [100, 200, 'All']
                    ],
                });

                function format(d) {
                    var str = '';
                    for (i = 0; i < d.length; i++) {
                        if (d[i + 3] != undefined) {
                            str = str + '<tr><td>' + d[i + 3] + '</td><tr>';
                        }
                        if (i == d.length - 1) {
                            localStorage.setItem("tableData", str);
                        }
                    }

                    var tdata = '<tr>' + localStorage.getItem("tableData") + '</tr>';
                    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                        tdata +
                        '</table><div class="btn-rounded"><a class="btn btn-info tool" data-tip="Edit" onclick="editProjectsfieldsvalueForm(' + d[1] + ',' + d[2] + ',`' + d[0] + '`)" href="javascript:void(0)"><i class="fa green fa-edit"></i></a></div>';
                }

                $('#constituencyNodestable tbody').on('click', 'td.details-control', function() {
                    var tr = $(this).closest('tr');
                    var row = table2.row(tr);

                    if (row.child.isShown()) {
                        row.child.hide();
                        tr.removeClass('shown');
                    } else {
                        row.child(format(row.data())).show();
                        tr.addClass('shown');
                    }
                });
            </script>
            <?php
        }
    }
    /***************/
    /***************/
    function getprojectfields()
    {
        if (isset($_POST['projectfield_id'])) {
            $id = $_POST['projectfield_id'];
            $proid = $_POST['proid'];
            $result = $this->model->getDataFieldsByFieldId($id);
            if (!empty($result)) {
                $data = $result[0];
                $fieldData = json_decode($data['field_data']);
                if ($data['field_type'] == 'Text') { ?>
                    <script>
                        $('.inner-data').hide();
                        $('.invert-node').hide();
                        $('.graph-type').hide();
                        $('.grouping-method').hide();
                        $('.average-override').hide();
                        $('.dataset_summary').hide();
                    </script>
                <?php
                } else if ($data['field_type'] != 'Text' && $data['field_type'] != 'Hyperlink') { ?>
                    <script>
                        $('.inner-data').show();
                    </script>
                <?php } else if ($data['field_type'] == 'Hyperlink') { ?>
                    <script>
                        $('.inner-data').hide();
                        $('.comparable-data').hide();
                    </script> <?php }
                            if (!$fieldData->isMultivalued != 'true') {
                                if ($data['field_type'] != 'Text' && $data['field_type'] != 'Hyperlink' && $data['field_type'] != 'Percentage') {
                                ?>
                        <script>
                            $('.graph-type').show();
                        </script>
                    <?php } ?>
                    <script>
                        $('.node-ranking-data').hide();
                    </script>
                <?php
                            } else {
                ?>
                    <script>
                        $('.node-ranking-data').show();
                        $('.graph-type').hide();
                    </script>
                <?php } ?>
                <?php
                if (!$fieldData->comparable != 'true') {
                    if ($data['field_type'] != 'Hyperlink' && $data['field_type'] != 'Text') {
                ?>
                        <script>
                            $('.grouping-method').show();
                        </script>
                    <?php }
                } else { ?>
                    <script>
                        $('.grouping-method').hide();
                    </script>
                <?php } ?>
                <?php
                if (!$fieldData->showAverageInDataSetSummary != 'true') {
                    if ($data['field_type'] != 'Hyperlink' && $data['field_type'] != 'Text') {
                ?>
                        <script>
                            $('.average-override').show();
                        </script>
                    <?php }
                } else { ?>
                    <script>
                        $('.average-override').hide();
                    </script>
                    <?php }
                if (!$fieldData->showChartDatasetSummary != 'true') {
                    if ($data['field_type'] != 'Hyperlink' && $data['field_type'] != 'Text') {
                    ?>
                        <script>
                            $('.dataset_summary').show();
                        </script>
                    <?php
                    }
                } else {
                    ?>
                    <script>
                        $('.dataset_summary').hide();
                    </script>
                <?php }
                if (!$fieldData->displayRankings != 'true') {
                ?>
                    <script>
                        $('.invert-node').show();
                    </script>
                <?php } else { ?>
                    <script>
                        $('.invert-node').hide();
                    </script>
                <?php } ?>
                <div class="message"></div>
                <div class="modal-header">
                    <button type="button" class="close editdatafield" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title">Edit data fields</h5>

                </div>

                <div class="modal-body">
                    <form action="javascript:void(0)" id="updatedataFields" class="edit-project" method="post">

                        <div class="form-group">
                            <label for="">Name</label>
                            <textarea class="form-control required textarea-input" name="name" id="name" placeholder="Name"><?php echo $data['field_name']; ?></textarea>
                            <div class="text-danger"></div>
                            <span class="error" style="display:none">Name is required</span>
                        </div>
    <div class="form-group">
    <label for="">Display Name</label>
     <textarea class="form-control required textarea-input" name="display_name" id="disname" placeholder="Name"><?php if($data['display_name'] != null) { echo $data['display_name']; } else {  echo $data['field_name']; } ?></textarea>
     <div class="text-danger"></div>
     <span class="error" style="display:none">Display name is required</span>
    </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea type="text" class="form-control" name="description" id="description" placeholder="Description"><?php echo $data['description']; ?></textarea>
                        </div>
                        <?php 
                        if ($data['parentId'] != 0){
                             $parent = $this->model->getDataFieldsByFieldId($data['parentId']);
                        }else{
                            $parent = null;
                        }
                        ?>
                        <div 
                        style="<?php if ($data['parentId'] != 0) {
                                        // echo 'display:none';
                                        if($parent){
                                            if($parent[0]['restrict_children'] == 1){ 
                                                echo 'display:none'; 
                                            }
                                        }
                                    } ?>"
                                    >
                            <div class="form-group">
                                <label for="">Type</label>
                                <select class="form-control" id="dataType" onchange="getType(this)" name="type">
                                    <option value="Number" <?php if ($data['field_type'] == 'Number') {
                                                                echo 'selected';
                                                            } ?>>Number</option>
                                    <option value="Text" <?php if ($data['field_type'] == 'Text') {
                                                                echo 'selected';
                                                            } ?>>Text</option>
                                    <option value="Percentage" <?php if ($data['field_type'] == 'Percentage') {
                                                                    echo 'selected';
                                                                } ?>>Percentage</option>
                                    <option value="Decimal" <?php if ($data['field_type'] == 'Decimal') {
                                                                echo 'selected';
                                                            } ?>>Decimal</option>
                                    <option value="Hyperlink" <?php if ($data['field_type'] == 'Hyperlink') {
                                                                    echo 'selected';
                                                                } ?>>Hyperlink</option>
                                    <option value="Pound" <?php if ($data['field_type'] == 'Pound') {
                                                                echo 'selected';
                                                            } ?>>Pound</option>
                                    <option value="Euro" <?php if ($data['field_type'] == 'Euro') {
                                                                echo 'selected';
                                                            } ?>>Euro</option>
                                    <option value="Dollar" <?php if ($data['field_type'] == 'Dollar') {
                                                                echo 'selected';
                                                            } ?>>Dollar</option>
                                </select>
                            </div>
                            <div class="form-group comparable-data">

                                <div class="toggleWrapper">
                                    <label for="">Display data on heatmap</label>
                                    <input type="checkbox" name="comparable" id="comparable" class="dn" value="<?php if($data['field_type'] == 'Hyperlink'){echo 'false';}else{ echo 'true'; }?>" <?php if (!$fieldData->comparable != 'true') {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>>
                                    <label for="comparable" class="toggle"><span class="toggle__handler"></span></label>
                                </div>
                                <div class="grouping-method1" style="display:none;">
                                    <label for="">Grouping method</label>
                                    <select class="form-control" name="grouping">
                                        <option value="Percentiles" <?php if ($fieldData->groupingMethod == 'Percentiles') {
                                                                        echo 'selected';
                                                                    } ?>>Percentiles</option>
                                        <option value="EqualRanges" <?php if ($fieldData->groupingMethod == 'EqualRanges') {
                                                                        echo 'selected';
                                                                    } ?>>Equal Ranges</option>
                                    </select>
                                </div>
                                <!-- <input type="hidden" value="Percentiles" name="grouping" /> -->
                            </div>
	<!--=========-->
	<div class="form-group link_and_text" <?php if(!empty($fieldData->link_text) && $data['field_type'] == 'Hyperlink'){ ?>  <?php } else{ echo 'style="display:none;"'; } ?>>
	<label for="">Link Text</label>
	<input type="text" class="form-control" name="link_text" id="link_text" placeholder="Link Text" value="<?php if(!empty($fieldData->link_text) && $data['field_type'] == 'Hyperlink'){ echo !empty($fieldData->link_text) ? $fieldData->link_text : 'Click Here'; } ?>">
	</div>
	<!--=========-->
                            <div class="form-group">
                                <div class="toggleWrapper">
                                    <label for="">Hide field on node view</label>
                                    <input type="checkbox" name="hide_node" id="hide_node_option" class="dn" value="yes" <?php if ($data['hide_node'] == 'yes') {
                                                                                                                                echo 'checked';
                                                                                                                            } ?>>
                                    <label for="hide_node_option" class="toggle"><span class="toggle__handler"></span></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="toggleWrapper">
                                    <label for="">Hide empty values on node view</label>
                                    <input type="checkbox" name="hide_empty_valu_on_node" id="hide_empty_valu_on_node" class="dn" value="yes" <?php if ($data['hide_empty_valu_on_node'] == 'yes') {
                                                                                                                                echo 'checked';
                                                                                                                            } ?>>
                                    <label for="hide_empty_valu_on_node" class="toggle"><span class="toggle__handler"></span></label>
                                </div>
                            </div>
                            <div class="inner-data">
                                <div class="form-group">
                                    <div class="toggleWrapper">
                                        <label for="">Show average</label>
                                        <input type="checkbox" name="overall_range" id="overall_range" class="dn" value="true" <?php if (!$fieldData->includeAverageInNodeGraphs != 'true') { echo 'checked';} ?>>
                                        <label for="overall_range" class="toggle"><span class="toggle__handler"></span></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="toggleWrapper">
                                        <label for="">Show average without empty nodes</label>
                                        <input type="checkbox" name="average_without_empty_nodes" id="average_without_empty_nodes" class="dn" value="true" <?php if (!$fieldData->average_without_empty_nodes != 'true') { echo 'checked';} ?>>
                                        <label for="average_without_empty_nodes" class="toggle"><span class="toggle__handler"></span></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="toggleWrapper">
                                        <label for="">Override calculated average</label>
                                        <input type="checkbox" name="override_average" id="override_average" class="dn" value="true" <?php if (!$fieldData->showAverageInDataSetSummary != 'true') {
                                                                                                                                            echo 'checked';
                                                                                                                                        } ?>>
                                        <label for="override_average" class="toggle"><span class="toggle__handler"></span></label>
                                    </div>
                                    <div class="average-override">
                                        <label for="">Average Override</label>
                                        <input type="number" class="form-control" name="average_override_number" id="average_override_number" placeholder="" value="<?php echo $fieldData->averageOverride; ?>">
                                    </div>
                                </div>

                                <!--  <div class="form-group">-->
                                <!-- <div class="toggleWrapper">-->
                                <!--       <label for="">Show chart in the data set summary</label>  -->
                                <!-- <input type="checkbox" name="chart_data_set_summary" id="chart_data_set_summary" class="dn" value="true" <?php // if(!$fieldData->showChartDatasetSummary != 'true'){ echo 'checked';  } 
                                                                                                                                                ?>>-->
                                <!-- <label for="chart_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>-->
                                <!--</div>-->
                                <!--<div class="dataset_summary">-->
                                <!-- <div class="toggleWrapper">-->
                                <!--       <label for="">Exclude minimum from data set summary chart</label>  -->
                                <!-- <input type="checkbox" name="exclude_minimum_data_set_summary" id="exclude_minimum_data_set_summary" class="dn" value="true" <?php // if(!$fieldData->excludeMinFromDataSetSummaryGraph != 'true'){ echo 'checked';  } 
                                                                                                                                                                    ?>>-->
                                <!-- <label for="exclude_minimum_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>-->
                                <!--</div>-->

                                <!-- <div class="toggleWrapper">-->
                                <!--       <label for="">Exclude maximum from data set summary chart</label>  -->
                                <!-- <input type="checkbox" name="exclude_maximum_data_set_summary" id="exclude_maximum_data_set_summary" class="dn" value="true" <?php // if(!$fieldData->excludeMaxFromDataSetSummaryGraph != 'true'){ echo 'checked';  } 
                                                                                                                                                                    ?>>-->
                                <!-- <label for="exclude_maximum_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>-->
                                <!--</div>-->

                                <!-- <div class="toggleWrapper">-->
                                <!--       <label for="">Exclude average from data set summary chart</label>  -->
                                <!-- <input type="checkbox" name="exclude_average_data_set_summary" id="exclude_average_data_set_summary" class="dn" value="true" <?php //if(!$fieldData->excludeAverageFromDataSetSummaryGraph != 'true'){ echo 'checked';  } 
                                                                                                                                                                    ?>>-->
                                <!-- <label for="exclude_average_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>-->
                                <!--</div>-->
                                <!--</div>-->

                                <!--</div>-->
                                <!--  <div class="form-group">-->
                                <!-- <div class="toggleWrapper">-->
                                <!--       <label for="">Show total in the data set summary</label>  -->
                                <!-- <input type="checkbox" name="total_data_set_summary" id="total_data_set_summary" class="dn" value="true" <?php //if(!$fieldData->showTotalInDataSetSummary != 'true'){ echo 'checked';  } 
                                                                                                                                                ?>>-->
                                <!-- <label for="total_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>-->
                                <!--</div>-->
                                <!--</div>-->
                                <!--</div>-->
                                <!--   <div class="form-group multivalued-data" style="">-->
                                <!-- <div class="toggleWrapper">-->
                                <!--       <label for="">Multivalued</label>  -->
                                <!-- <input type="checkbox" name="multivalued" id="multivalued" class="dn" value="true" <?php //if(!$fieldData->isMultivalued != 'true'){ echo 'checked';  } 
                                                                                                                        ?>>-->
                                <!-- <label for="multivalued" class="toggle"><span class="toggle__handler"></span></label>-->
                                <!--</div>-->
                                <!--<div class="graph-type">-->
                                <!--  <label for="">Graph Type</label>-->
                                <!-- <select class="form-control" name="graphtype">-->
                                <!--     <option disabled>Select graph</option> -->
                                <!--    <option value="BarGraph" <?php //if($fieldData->graphType == 'BarGraph'){ echo 'selected';  } 
                                                                    ?>>Bar graph</option> -->
                                <!--    <option value="LineGraph" <?php // if($fieldData->graphType == 'LineGraph'){ echo 'selected';  } 
                                                                    ?>>Line graph</option> -->
                                <!-- </select>-->
                                <!-- </div>-->
                                <!--</div>-->
                                <div class="form-group node-ranking-data">
                                    <div class="toggleWrapper">
                                        <label for="">Display the node rankings</label>
                                        <input type="checkbox" name="node_ranking" id="node_ranking" class="dn" value="true" <?php if (!$fieldData->displayRankings != 'true') {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                        <label for="node_ranking" class="toggle"><span class="toggle__handler"></span></label>
                                    </div>
                                </div>
                                <div class="form-group invert-node">
                                    <div class="toggleWrapper">
                                        <label for="">Invert the node rankings</label>
                                        <input type="checkbox" name="invert_node_ranking" id="invert_node_ranking" class="dn" value="true" <?php if (!$fieldData->invertRankings != 'true') {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?>>
                                        <label for="invert_node_ranking" class="toggle"><span class="toggle__handler"></span></label>
                                    </div>
                                </div>
                            </div>
	<!------------------->
	<div class="form-group">
	<label for="">Map Areas Border Colour</label>
	<input type="color" class="form-control" name="map_areas_border_colour" id="map_areas_border_colour" placeholder="Map Areas Border Colour" value="<?php echo !empty($fieldData->map_areas_border_colour) ? $fieldData->map_areas_border_colour : '#646464'; ?>">
	</div>
	<!------------------->	
                        </div>
                        <input type="hidden" value="<?php echo $id; ?>" name="id" />
                        <input type="hidden" value="<?php echo $proid; ?>" name="proid" />
                        <button type="button" id="datafield_btn_update" class="btn cus-btn" onclick="datafieldBtnUpdate()">Update</button>
                    </form>
                </div>
        <?php
            }
        } else {
            $ret = array('status' => 0, 'msg' => 'Wrong request!');
            echo json_encode($ret);
        }
    }
    /***************/
    function updatedatafields()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $dname = $_POST['display_name'];
            if ($dname == null) {
                $dname = $name;
            }
            $type = $_POST['type'];
            $hide_node = isset($_POST['hide_node']) ? $_POST['hide_node'] : null;
            $hide_empty_valu_on_node = isset($_POST['hide_empty_valu_on_node']) ? $_POST['hide_empty_valu_on_node'] : null;
            $proid = $_POST['proid'];
            $description = $_POST['description'];
            $myObj = new stdClass;

            $myObj->comparable = (isset($_POST['comparable']) && $_POST['comparable']) ? $_POST['comparable'] : false;
            $myObj->isMultivalued = (isset($_POST['multivalued']) && $_POST['multivalued']) ? $_POST['multivalued'] : false;
            $myObj->displayRankings = (isset($_POST['node_ranking']) && $_POST['node_ranking']) ? $_POST['node_ranking'] : false;
            $myObj->invertRankings = (isset($_POST['invert_node_ranking']) && $_POST['invert_node_ranking']) ? $_POST['invert_node_ranking'] : false;
            $myObj->groupingMethod = (isset($_POST['grouping']) && $_POST['grouping']) ? $_POST['grouping'] : '';
            $myObj->includeAverageInNodeGraphs = isset($_POST['overall_range']) ? $_POST['overall_range'] : false;
            $myObj->showAverageInDataSetSummary = (isset($_POST['override_average']) && $_POST['override_average']) ? $_POST['override_average'] : false;
            $myObj->averageOverride = (isset($_POST['override_average']) && $_POST['override_average']) ? $_POST['average_override_number'] : null;
            $myObj->showChartDatasetSummary = (isset($_POST['chart_data_set_summary']) && $_POST['chart_data_set_summary']) ? $_POST['chart_data_set_summary'] : false;
            $myObj->showTotalInDataSetSummary = (isset($_POST['total_data_set_summary']) && $_POST['total_data_set_summary']) ? $_POST['total_data_set_summary'] : false;
            $myObj->excludeMinFromDataSetSummaryGraph = (isset($_POST['exclude_minimum_data_set_summary']) && $_POST['exclude_minimum_data_set_summary']) ? $_POST['exclude_minimum_data_set_summary'] : false;
            $myObj->excludeMaxFromDataSetSummaryGraph =  (isset($_POST['exclude_maximum_data_set_summary']) && $_POST['exclude_maximum_data_set_summary']) ? $_POST['exclude_maximum_data_set_summary'] : false;
            $myObj->excludeAverageFromDataSetSummaryGraph = (isset($_POST['exclude_average_data_set_summary']) && $_POST['exclude_average_data_set_summary']) ? $_POST['exclude_average_data_set_summary'] : false;
            $myObj->graphType = (isset($_POST['graphtype']) && $_POST['graphtype'])  ? $_POST['graphtype'] : '';
			$myObj->link_text = (isset($_POST['link_text']) && $_POST['link_text']) ? $_POST['link_text'] : '';
			$myObj->map_areas_border_colour = (isset($_POST['map_areas_border_colour']) && $_POST['map_areas_border_colour']) ? $_POST['map_areas_border_colour'] : '';
			$myObj->average_without_empty_nodes = (isset($_POST['average_without_empty_nodes']) && $_POST['average_without_empty_nodes']) ? $_POST['average_without_empty_nodes'] : false;

            $myObj->columns = array(
                'name' => $name,
                'icon' => null,
                'label' => null,
                'columnIndex' => null,
                'averageOverride' => isset($_POST['average_override_number']) ? $_POST['average_override_number'] : null,
                'displayRankings' => isset($_POST['node_ranking']) ? $_POST['node_ranking'] : false,
                'invertRankings' => isset($_POST['invert_node_ranking']) ? $_POST['invert_node_ranking'] : false,
                'maxValue' => null,
                'minValue' => null,
                'average' => null,
                'totalValue' => null
            );
            $myObj->maxValue = null;
            $myObj->minValue = null;
            $myObj->average = null;
            $myObj->totalValue = null;
            $myJSON = json_encode($myObj);

            $data = $this->model->getDataFieldsByMultiple($id, $name, $proid);
            if (!empty($data)) {
                echo json_encode(array('success' => 0, 'msg' => 'Name alerady exists!'));
                exit;
            }
            $updateData = $this->model->updateProjectFieldsById($name, $dname, $type, $hide_node, $hide_empty_valu_on_node, $description, $myJSON, $id);
             $parent = $this->model->getDataFieldsByFieldId($id);
             if(!empty($parent)){
                 $parent = $parent[0];
                 if($parent['restrict_children'] == 1){
                      $updateData2 = $this->model->updateProjectFieldsByParentId($type, $hide_node, $hide_empty_valu_on_node, $description, $myJSON, $id);
                 }
             }

            $_SESSION["success_msg"] = 'Datafield updated successfully.';
            echo json_encode(array('success' => 1, 'msg' => 'Datafield updated successfully.', 'redirect_url' => $_SERVER['HTTP_REFERER']));
        } else {
            $ret = array('status' => 0, 'msg' => 'Wrong request!');
            echo json_encode($ret);
        }
    }

    function copyprojects($incryptId)
    {

        $uid = $_SESSION['uid'];
        $key = 'Hl2018@1212';
        $prodecryptid = openssl_decrypt(hex2bin($incryptId), 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        $newfieldids = array();
        $oldfieldids = array();

        $projectsData = $this->model->getProjectById($prodecryptid);
        $projects = $projectsData;
        foreach ($projects as $pro) {
            $idClient = $pro['id_client'];
            $id_map_template = $pro['id_map_template'];
            $copytext = explode("-", $pro['name']);
            $lastElement = end($copytext);

            $name = $this->model->checklast_copy($copytext[0]);

            $nexp_arr = explode('-', $name);
            if (count($nexp_arr) > 1) {
                $field_name_copy = '' . end($nexp_arr);
            }

            $title = $pro['title'];
            $logo = $pro['logo'];
            $description = $pro['description'];
            $datafield_label_style = $pro['datafield_label_style'];
            $key_colors = $pro['key_colors'];
            $footer_content = $pro['footer_content'];
            $sequence_no = $pro['sequence_no'];
            $visibility = '0';
            $password_protected = '0';
            $password = null;
            $copycountnum = $pro['copy_count'] + 1;
            $font = $pro['font'];
            $is_mp = $pro['is_mp'];
            $is_charts = $pro['is_charts'];
            $is_social_share = $pro['is_social_share'];
            $is_email_share = $pro['is_email_share'];
            $is_tweet_mp = $pro['is_tweet_mp'];

            $description1 = $description;
            $node_description1 = $pro['node_description'];

            $colorsecond = $pro['secondary_color'];
            $colorprime = $pro['primary_color'];
            $text_color = $pro['text_color'];
            $text_color2 = $pro['text_color2'];
            $text_color3 = $pro['text_color3'];


            // new 

            $email_sub =  $pro['email_sub'];
            $message =  $pro['message'];
            $is_facebook =  $pro['is_facebook'];
            $is_insta =  $pro['is_insta'];
            $is_twitter =  $pro['is_twitter'];
            $is_linkedin =  $pro['is_linkedin'];
            $is_email_friend = $pro['is_email_friend'];
            $email_friend_text = $pro['email_friend_text'];
            $email_friend_title = $pro['email_friend_title'];
            $tweet_mp_text = $pro['tweet_mp_text'];


            $projectsData = $this->model->copyProject($idClient, $id_map_template, $name, $title, $logo, $description1, $datafield_label_style, $colorprime, $colorsecond, $text_color, $text_color2, $text_color3, $key_colors, $footer_content, $node_description1, $sequence_no, $visibility, $password_protected, $password, $font, $is_mp, $is_charts, $is_social_share, $is_email_share, $is_tweet_mp, $copycountnum, $uid, $email_sub, $message, $is_facebook, $is_insta, $is_twitter, $is_linkedin, $is_email_friend, $email_friend_text, $email_friend_title, $tweet_mp_text);

            $latestId = $projectsData;
            $projectfield = $this->model->getDataFieldsById($prodecryptid);


            foreach ($projectfield as $profield) {
                $fieldName = $profield['field_name'];
                $fieldType = $profield['field_type'];
                $description1 = $profield['description'];
                $field_data = $profield['field_data'];
                $sequence_no = $profield['sequence_no'];
                $first_interval = $profield['first_interval'];
                $last_interval = $profield['last_interval'];

                $description = $description1;

                $insertfieldQuery = $this->model->insertProjectFileds($latestId, $fieldName, $fieldType, $description, $field_data, $sequence_no, $first_interval, $last_interval);


                $latestfieldId = $insertfieldQuery;
                array_push($newfieldids, $latestfieldId);
                array_push($oldfieldids, $profield['id_project_field']);
            }

            $chartdata = $this->model->getchartWizard($prodecryptid);

            foreach ($chartdata as $cdata) {
                $cname = $cdata['name'];
                $graphfor = $cdata['graph_for'];
                $graph_type = $cdata['graph_type'];
                $fieldData = $cdata['datafields'];
                $mapWidth = $cdata['map_width'];

                $sequence_no = $cdata['sequence_no'];

                if ($fieldData != null) {
                    $fieldData = serialize($fieldData);
                }

                $copyChartData = $this->model->copyChartData($cname, $graphfor, $graph_type, $fieldData, $mapWidth, $sequence_no, $latestId);
            }

            for ($i = 0; $i < count($oldfieldids); $i++) {
                $oldfieldId = $oldfieldids[$i];
                $projectfieldvalue = $this->model->datafieldvalueByid($prodecryptid, $oldfieldId);

                foreach ($projectfieldvalue as $profieldv) {
                    $city_id = $profieldv['city_id'];

                    $field_id = $newfieldids[$i];

                    $field_value = $profieldv['field_value'];

                    $insetfieldvalueQuery = $this->model->insertFieldvalue($latestId, $city_id, $field_id, $field_value);
                }
            }
        }

        $key = 'Hl2018@1212';
        $encrypted_id = openssl_encrypt($latestId, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        $encrypted_id = strtolower(bin2hex($encrypted_id));
        $_SESSION["success_msg"] = 'project copied successfully.';
        ?>
        <script>
            localStorage.setItem('activetab', 'li2');
            localStorage.setItem('tabid', '#2a');
            location.href = '<?php echo BASE_URL; ?>projects/viewprojects/<?php echo $encrypted_id; ?>';
        </script>

        <?php
    }

    function ajaxfunctions()
    {
        $action = $_POST['action'];
        if ($action == 'filterbyclientreflectgroup') {
            $cid = $_POST['cid'];
            $_SESSION['clientSelected'] = $cid;

            $dataGroup = $this->model->getProjectGroupClientId($cid);
        ?>
            <option>Filter by group</option>
            <?php
            foreach ($dataGroup as $dgroup) {
            ?>
                <option value="<?php echo $dgroup['id']; ?>"><?php echo $dgroup['name']; ?></option>
            <?php
            }
        }
    }
    function saveDatagroupParentChild()
    {
        $short_id = $_POST['shortposition'];
        $sequence = $_POST['sequence'];
        $count = 0;
        $shortingdata = json_decode($_POST['shortingdata'], true);
        $msg = false;
        $cn = 0;

        foreach ($short_id as $id) {
            if ($sequence != null) {
                $sequence1 = $sequence[$cn];
            }

            $queryup = $this->model->setFieldSequence($sequence1, $id);

            if ($queryup) {
            } else {
                echo '';
            }
            $cn++;
        }
        foreach ($shortingdata as $sData) {
            $fieldid = $sData['item_id'];
            $parentid = $sData['parent_id'];
            $count++;
            if ($parentid != 'root') {

                $parentData = $this->model->getDataFieldsByFieldId($parentid);
                $parentData = $parentData[0];

                if ($parentData['isGroup'] != 0) {
                     $pftype = $parentData['field_type'];
                    $description = $parentData['description'];
                    $pfdata = $parentData['field_data'];
                    if($parentData['restrict_children'] == true || $parentData['restrict_children'] == 1){
                         $result = $this->model->updateProjectFieldsortingData($pftype, $pfdata, $parentid, $fieldid);
                    }else{
                         $result = $this->model->updateProjectFieldsortingDataWithRestrict($parentid, $fieldid);
                    }
                   
                    $msg = true;
                } else {
                    $result = $this->model->setIsgroup($fieldid);
                }
            } else {

                $result = $this->model->setparentId($fieldid);
                $msg = true;
            }
        }
        // $_SESSION["success_msg"]='Updated successfully.';
        if ($msg) {
            echo json_encode(array('success' => 1, 'msg' => 'Updated successfully.'));
        }
    }

    function getmapkey()
    {
        //start

        $id = $_POST['projectfield_id'];
        $proid = $_POST['proid'];

        $proDatas = $this->model->getProjectById($proid);
        $proData = $proDatas[0];
        $cid = $proData['id_client'];

        $profieldDatas = $this->model->getDataFieldsByFieldId($id);
        $profieldData = $profieldDatas[0];

        $clientDatas = $this->model->getClientsById($cid);
        $clientData = $clientDatas[0];

        $keyColor = $proData['key_colors'];
        $clientcolor = $clientData['colours'];

        $pfielfcolor = $profieldData['key_colors'];
        if ($pfielfcolor == null) {
            if ($keyColor == null) {
                $colorArray = $clientcolor;
            } else {
                $colorArray = $keyColor;
            }
        } else {
            $colorArray = $pfielfcolor;
        }
        if ($colorArray != null) {
            $colorArray = unserialize($colorArray);
        }

        $constant_fmin = $profieldData['first_interval'];
        $fmin = $profieldData['first_interval'];
        $fmax = $profieldData['last_interval'];

        if (!empty($fmax) && empty($fmin)) {
            $fmin = '0';
            $constant_fmin = '0';
        }


        $dataMaximum = $this->model->maxfieldValue($id);
        $dataMax = $dataMaximum[0];

        $dataMinimum = $this->model->minfieldValue($id);
        $dataMin = $dataMinimum[0];


        $counttotalvalue = $this->model->countfieldValue($id);
        $counttotal = $counttotalvalue[0];
        $color_count = count($colorArray);

        $max = $dataMax['max'];
        $lastkeymaxvalue = $dataMax['max'];

        if ($fmin == null) {
            $min = $dataMin['min'];
        } else {
            $min = $fmin;
            $dataMin['min'] = $fmin;
        }
        if ($fmax == null) {
            $max = $dataMax['max'];
        } else {
            $max = $fmax;
            $dataMax['max'] = $fmax;
        }

        if ($fmax != null && $fmin != null) {
            $newCount = count($colorArray) - 1;
            $avg = round(($max - $min) / $newCount, 2);
            $avgDiff = $avg;
            $fmaxNew = $max;
        } else if ($fmax != null && $fmin == null) {
            $newCount = count($colorArray) - 1;
            $avg = round(($max - $min) / $newCount, 2);
            $avgDiff = $avg;
            $fmaxNew = $max;
        } else {

            $avg = round(($max - $min) / count($colorArray), 2);
            $avgDiff = $avg;
        }

        $max_key_values = isset($profieldData['max_key_values']) ?  unserialize($profieldData['max_key_values']) : null;
        $min_key_values = isset($profieldData['min_key_values']) ? unserialize($profieldData['min_key_values']) : null;

        $key_value_option = $profieldData['key_value_option'];

        $show_last_key = $profieldData['show_last_key'];
        if ($show_last_key == 'Yes') {
            ?>
            <script>
                $('.lastkey').attr('type', 'text');
                $('.lasykeyplus').hide();
                $('.lasykeyminus').show();
            </script>
        <?php
        }

        if ($key_value_option == 'Equal Ranges' && $profieldData['field_type'] != 'Text') {
        ?>
            <script>
                $('.minKeyvalue').attr('readonly', true);
                $('.maxKeyvalue').attr('readonly', true);
                $('#l_interval').removeAttr('readonly');
                $('#f_interval').removeAttr('readonly');
            </script>
        <?php
        } else if ($key_value_option == 'Custom Ranges' && $profieldData['field_type'] != 'Text') {
        ?>
            <script>
                $('.minKeyvalue').removeAttr('readonly');
                $('.maxKeyvalue').removeAttr('readonly');
                $('#l_interval').attr('readonly', true);
                $('#f_interval').attr('readonly', true);
            </script>
        <?php
        } else if ($key_value_option == 'Equal Count') {
        ?>
            <script>
                $('.lastkeyoption').hide();
                $('.minKeyvalue').attr('readonly', true);
                $('.maxKeyvalue').attr('readonly', true);
                $('#l_interval').attr('readonly', true);
                $('#f_interval').attr('readonly', true);
            </script>
        <?php
        }

        $ftype = $profieldData['field_type'];
        $data_field_value = $this->model->select_data_field_value_by_fid($id);
        $UniqueArray = array();
        foreach ($data_field_value as $dfv) {
            if ($dfv['field_value'] && $dfv['field_value'] != null) {
                $trimval = trim($dfv['field_value']);
                if (!in_array($trimval, $UniqueArray)) {
                    array_push($UniqueArray, $trimval);
                }
            }
        }
        $UniqueArray = array_unique($UniqueArray);

        $display_min_array = array();
        $display_max_array = array();
        ?>
        <div class="modal-header">
            <button type="button" class="close editdatafield" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h5 class="modal-title">Edit map key</h5>
            <input type="hidden" name="counttotal" value="<?php echo $counttotal['total']; ?>">
        </div>
        <div class="modal-body">
            <form action="javascript:void(0)" id="updatemapkey" class="edit-project" method="post">
                <div class="form-group">
                    <p>Please select key value Ranges option:</p>
                    <div>
                        <input type="radio" id="Equal_Ranges" name="key_value_option" <?php echo $profieldData['key_value_option'] == 'Equal Ranges' ? 'checked' : ''; ?> value="Equal Ranges">
                        <label for="Equal_Ranges">Equal Ranges</label><br>
                        <input type="radio" id="Equal_Count" name="key_value_option" <?php echo $profieldData['key_value_option'] == 'Equal Count' ? 'checked' : ''; ?> value="Equal Count">
                        <label for="Equal_Count">Equal Count</label><br>
                        <input type="radio" id="Custom_Ranges" name="key_value_option" <?php echo $profieldData['key_value_option'] == 'Custom Ranges' ? 'checked' : ''; ?> value="Custom Ranges">
                        <label for="Custom_Ranges">Custom Ranges</label>
                    </div>
                </div>
                <input type="hidden" value="<?php echo $id; ?>" name="id" />
                <input type="hidden" value="<?php echo $proid; ?>" name="proid" />
                <input type="hidden" name="datafieldtype" id="datafieldtype" value="<?php echo $ftype; ?>">
                <input type="hidden" name="key_value_option_value" id="key_value_option_value" value="<?php echo $key_value_option; ?>">
                <div class="form-group">
                    <label for="">First interval</label>
                    <input type="text" class="form-control required" <?php echo ($ftype == 'Text') ? 'readonly' : ''; ?> name="f_interval" id="f_interval" placeholder="First interval" value="<?php echo $profieldData['first_interval']; ?>">

                </div>

                <div class="form-group">
                    <label for="">Final Interval</label>
                    <input type="text" class="form-control required" <?php echo ($ftype == 'Text') ? 'readonly' : ''; ?> name="l_interval" id="l_interval" placeholder="Last Interval" value="<?php echo $profieldData['last_interval']; ?>">

                </div>
                <div class="form-group text-right">
                    <button class="refresh-value-btn btn cus-btn" <?php echo ($profieldData['key_value_option'] == 'Equal Ranges') ? '' : 'disabled'; ?> onclick="mapKeyBtnUpdate()">Refresh Value</button>
                </div>

                <div class="form-group linkvalues" style="<?php if ($profieldData['key_value_option'] != 'Custom Ranges') {
                                                                echo 'display:none';
                                                            } ?>">
                    <div class="toggleWrapper">
                        <label for="">Link values</label>
                        <input type="checkbox" name="link_values" id="link_values" class="dn" value="Yes" <?php if ($profieldData['link_values'] == 'Yes') {
                                                                                                                echo 'checked';
                                                                                                            } ?> />
                        <label for="link_values" class="toggle"><span class="toggle__handler"></span></label>
                    </div>
                </div>
                <div class="form-group lastkeyoption">
                    <div class="toggleWrapper">
                        <label for="">Show last key option</label>
                        <input type="checkbox" name="show_last_key" id="show_last_key" class="dn" value="Yes" <?php if ($profieldData['show_last_key'] == 'Yes') {
                                                                                                                    echo 'checked';
                                                                                                                } ?> />
                        <label for="show_last_key" class="toggle"><span class="toggle__handler"></span></label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <div id="colorm_type2">
                            <div class="color-append-boxm">
                                <label for="">Key colors:</label>

                                <?php
                                if ($ftype == 'Text') {
                                ?>
                                    <script>
                                        $('.linkvalues').hide();
                                        $('.lastkeyoption').hide();
                                    </script>
                                    <?php
                                    if ($max_key_values != null && count($max_key_values) > 0) {
                                        $UniqueArray = $max_key_values;
                                    }
                                    $count = 0;
                                    $uniqueCount = count($UniqueArray);
                                    foreach ($UniqueArray as $key => $color) {
                                        if ($count < 10) {
                                            $count++;  ?>
                                            <div class="colorBoxm">
                                                <label for="">Key color <?php echo $count; ?></label>
                                                <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo isset($colorArray[$key]) ? $colorArray[$key] : '#000000'; ?>" />
                                                <input type="color" class="colorInput" name="color[]" onchange="colorChange(this)" id="colors" value="<?php echo isset($colorArray[$key]) ? $colorArray[$key] : '#000000'; ?>" />
                                                <div class="color-min-max">
                                                    <?php
                                                    array_push($display_min_array, 'false');
                                                    array_push($display_max_array, isset($max_key_values[$key]) ? $max_key_values[$key] : (isset($UniqueArray[$key]) ? $UniqueArray[$key] : null));
                                                    ?>
                                                    <input type="hidden" class="form-control minKeyvalue" data-id="min-input<?php echo $key; ?>" value="" name="minKeyvalue[]">
                                                    <input type="text" class="form-control maxKeyvalue" data-id="max-input<?php echo $key; ?>" value="<?php echo isset($max_key_values[$key]) ? $max_key_values[$key] : (isset($UniqueArray[$key]) ? $UniqueArray[$key] : '0'); ?>" name="maxKeyvalue[]">
                                                </div>
                                                <?php
                                                if ($uniqueCount == $count || $count == 10) {
                                                ?>
                                                    <button class="removeBoxm" onclick="removeColorm(this,0,0,false,false)">
                                                        <img src="/uploads/close.png" alt="">
                                                    </button>
                                                <?php }
                                                ?>
                                            </div>
                                            <?php
                                        }
                                    }
                                } else {
                                    if ($key_value_option == 'Equal Count') {
                                        if ($colorArray != null) {
                                            $count = 0;
                                            $from = 0;
                                            $to = round($counttotal['total'] / $color_count);
                                            $devide = round($counttotal['total'] / $color_count);
                                            $px = $this->model->getEqualCountvalueswithIgnore($id);
                                            rsort($px);
                                            $newCOUNT =  count($px);
                                            $NEW_devide = round($newCOUNT / $color_count);
                                            $main_array = array();
                                            $arr = array();
                                            $fff = 0;
                                            $fff_1 = 0;
                                            $NEW_devide_1 = round($newCOUNT / $color_count);
                                            $allworked = true;
                                            if ($newCOUNT > $color_count) {
                                                foreach ($colorArray as $key => $color) {
                                                    $E_Arr = $this->model->getEqualCountvaluesV2($id, $fff_1, $NEW_devide_1);
                                                    if(!empty($E_Arr)){

                                                     

                                                        $arr = [min($E_Arr), max($E_Arr)];
                                                        if(in_array($arr, $main_array)){
                                                        $allworked = false;
                                                            }
                                                        array_push($main_array, $arr);
                                                        $arr = array();
                                                    }else{
                                                        $allworked = false;
                                                    }
                                                    if(min($E_Arr)==max($E_Arr)){
                                                        $allworked = false;
                                                    }
                                                    if ($key == ($color_count - 2)) {
                                                        $fff_1 = $fff_1 + $NEW_devide_1;
                                                        $NEW_devide_1 = $NEW_devide_1 + ($newCOUNT - ($NEW_devide_1 * $color_count));
                                                    } else {
                                                        $fff_1 = $fff_1 + $NEW_devide_1;
                                                    }
                                                }
                                            } else {
                                                $allworked = false;
                                            }

                                            //  if ($newCOUNT > $color_count && $allworked == true) {
                                            if ($newCOUNT > $color_count) {
                                            foreach ($colorArray as $key => $color) {
                                                $Equalcount_array = $this->model->getEqualCountvaluesV2($id, $fff, $NEW_devide);
                                                //   print_r($Equalcount_array);
                                                if ($count < 10) {
                                                    $count++;  ?>
                                                    <div class="colorBoxm">
                                                        <label for="">Key color <?php echo $count; ?></label>
                                                        <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo isset($colorArray[$key]) ? $colorArray[$key] : '#000000'; ?>" />
                                                        <input type="color" class="colorInput" name="color[]" onchange="colorChange(this)" id="colors" value="<?php echo isset($colorArray[$key]) ? $colorArray[$key] : '#000000'; ?>" />
                                                        <div class="color-min-max">
                                                            <?php
                                                            if ($count == 1) { ?>

                                                                <?php
                                                                  $thisMinvalue =min($Equalcount_array);
                                                                  $thisalue = max($Equalcount_array); 
                                                                  $thisMaxvalue = ((int)$thisalue >= (int)$thisMinvalue) ? $thisalue : $thisMinvalue;

                                                                array_push($display_min_array, min($Equalcount_array));
                                                                array_push($display_max_array, $thisMaxvalue);
                                                                ?>
                                                                <input type="number" class="form-control minKeyvalue" data-id="min-input<?php echo $key; ?>" value="<?php echo min($Equalcount_array); ?>" name="minKeyvalue[]">
                                                                <span class="lasykeyplus" style="display:none;">+</span>
                                                                <span class="lasykeyminus">-</span>
                                                                <input type="number" class="form-control lastkey maxKeyvalue" data-this='true1' data-id="max-input<?php echo $key; ?>" value="<?php echo $thisMaxvalue; ?>" name="maxKeyvalue[]">
                                                            <?php } else {
                                                            ?>
                                                                <?php
                                                                $thisMinvalue =min($Equalcount_array);
                                                                $thisalue = max($Equalcount_array); 
                                                                $thisMaxvalue = ((int)$thisalue >= (int)$thisMinvalue) ? $thisalue : $thisMinvalue;

                                                                array_push($display_min_array, min($Equalcount_array));
                                                                array_push($display_max_array, $thisMaxvalue);
                                                                ?>
                                                                <input type="number" class="form-control minKeyvalue" data-id="min-input<?php echo $key; ?>" value="<?php echo min($Equalcount_array); ?>" name="minKeyvalue[]">
                                                                <span>-</span>
                                                                <input type="number" class="form-control maxKeyvalue" data-id="max-input<?php echo $key; ?>" value="<?php echo $thisMaxvalue; ?>" name="maxKeyvalue[]">
                                                            <?php } ?>
                                                        </div>
                                                        <?php
                                                        if ($color_count == $count || $count == 10) {
                                                        ?>
                                                            <button class="removeBoxm" onclick="removeColorm(this,0,0,false,false)">
                                                                <img src="/uploads/close.png" alt="">
                                                            </button>
                                                        <?php }
                                                        ?>
                                                    </div>
                                                    <?php
                                                }

                                                if ($key == ($color_count - 2)) {
                                                    $fff = $fff + $NEW_devide;
                                                    $NEW_devide = $NEW_devide + ($newCOUNT - ($NEW_devide * $color_count));
                                                } else {
                                                    $fff = $fff + $NEW_devide;
                                                }
                                            }

                                        } else {
                                            ?>
                                            <script>
                                                    Swal.fire({
                                                        icon: 'error',
                                                        customClass: 'swal-wide',
                                                        title: "Invalid Equal count, instead choose custom range option.",showConfirmButton: true,onClose: () => {
                                                                $("input[name=key_value_option][value='Custom Ranges']").prop("checked",true);
                                                            mapKeyBtnUpdate();
                                                                    }
                                                                });
                                            </script>

                                            <?php
                                        }

                                        }
                                    } else {

                                        if ($colorArray != null) {
                                            $count = 0;
                                            foreach ($colorArray as $key => $color) {

                                                if ($key_value_option == 'Equal Ranges') {
                                                    $min_key_values = null;
                                                    $max_key_values = null;
                                                }
                                                $count++;
                                                $maxNew  = $max - $avgDiff;
                                                if ($count == count($colorArray)) {

                                                    if ($fmin != null) {
                                                        if ($fmin > 0 || $min_key_values[$key] == 0) {

                                                            $fm = $min + $avgDiff;
                                                    ?>
                                                            <div class="colorBoxm">
                                                                <label for="">Key color <?php echo $count; ?></label>
                                                                <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $color; ?>" />
                                                                <input type="color" class="colorInput" name="color[]" onchange="colorChange(this)" id="colors" value="<?php echo $color; ?>" />
                                                                <span><?php
                                                                        // echo '0'.' - '.$fmin; 
                                                                        ?>
                                                                    <div class="color-min-max">
                                                                        <?php
                                                                        array_push($display_min_array, $constant_fmin);
                                                                        array_push($display_max_array, isset($max_key_values[$key]) ? $max_key_values[$key] : $fm);
                                                                        ?>
                                                                        <input type="number" class="form-control minKeyvalue" data-id="min-input<?php echo $key; ?>" value="<?php echo $constant_fmin; ?>" name="minKeyvalue[]">
                                                                        <span>-</span>
                                                                        <input type="number" class="form-control maxKeyvalue" data-id="max-input<?php echo $key; ?>" value="<?php echo isset($max_key_values[$key]) ? $max_key_values[$key] : $fm; ?>" name="maxKeyvalue[]">
                                                                    </div>

                                                                <?php  }
                                                        } else {
                                                                ?>
                                                                <div class="colorBoxm">
                                                                    <label for="">Key color <?php echo $count; ?></label>
                                                                    <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $color; ?>" />
                                                                    <input type="color" class="colorInput" name="color[]" onchange="colorChange(this)" id="colors" value="<?php echo $color; ?>" />
                                                                    <span><?php
                                                                            // echo $min.' - '.$max; 
                                                                            ?>
                                                                        <div class="color-min-max">
                                                                            <?php
                                                                            array_push($display_min_array, isset($min_key_values[$key]) ? $min_key_values[$key] : $min);
                                                                            array_push($display_max_array, isset($max_key_values[$key]) ? $max_key_values[$key] : $max);
                                                                            ?>
                                                                            <input type="number" class="form-control minKeyvalue" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_key_values[$key]) ? $min_key_values[$key] : $min; ?>" name="minKeyvalue[]">
                                                                            <span>-</span>
                                                                            <input type="number" class="form-control maxKeyvalue" data-id="max-input<?php echo $key; ?>" value="<?php echo isset($max_key_values[$key]) ? $max_key_values[$key] : $max; ?>" name="maxKeyvalue[]">
                                                                        </div>
                                                                    <?php
                                                                }
                                                            } else if ($count == 1) {
                                                                if ($fmax != null) {
                                                                    ?>
                                                                        <div class="colorBoxm">
                                                                            <label for="">Key color <?php echo $count; ?></label>
                                                                            <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $color; ?>" />
                                                                            <input type="color" class="colorInput" name="color[]" onchange="colorChange(this)" id="colors" value="<?php echo $color; ?>" />
                                                                            <span><?php
                                                                                    // echo $fmax.'+'; 
                                                                                    ?>
                                                                                <div class="color-min-max">
                                                                                    <?php
                                                                                  
                                                                                    $thisMinvalue = isset($min_key_values[$key]) ? $min_key_values[$key] : ($fmax ? $fmax : $max - $avg);
                                                                                    $thisalue = isset($max_key_values[$key]) ? $max_key_values[$key] : $lastkeymaxvalue;
                                                                                    $thisMaxvalue = ((int)$thisalue >= (int)$thisMinvalue) ? $thisalue : $thisMinvalue;
                                                                                    array_push($display_min_array, $thisMinvalue);
                                                                                    array_push($display_max_array, $thisMaxvalue);
                                                                                    ?>
                                                                                    <input type="number" class="form-control minKeyvalue" data-id="min-input<?php echo $key; ?>" value="<?php echo $thisMinvalue; ?>" name="minKeyvalue[]">
                                                                                    <span class="lasykeyplus">+</span>
                                                                                    <span class="lasykeyminus" style="display:none;">-</span>
                                                                                    <input type="hidden" class="form-control lastkey maxKeyvalue" data-this='true2' data-id="max-input<?php echo $key; ?>" value="<?php echo $thisMaxvalue; ?>" name="maxKeyvalue[]">
                                                                                </div>
                                                                            <?php

                                                                        } else {
                                                                            ?>
                                                                                <div class="colorBoxm">
                                                                                    <label for="">Key color <?php echo $count; ?></label>
                                                                                    <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $color; ?>" />
                                                                                    <input type="color" class="colorInput" name="color[]" onchange="colorChange(this)" id="colors" value="<?php echo $color; ?>" />
                                                                                    <span><?php
                                                                                            // echo $maxNew.'+';
                                                                                            ?>
                                                                                        <div class="color-min-max">
                                                                                            <?php

                                                                                            $thisMinvalue = isset($min_key_values[$key]) ? $min_key_values[$key] : ($maxNew ? $maxNew : $max - $avg);
                                                                                            $thisalue = isset($max_key_values[$key]) ? $max_key_values[$key] : $lastkeymaxvalue;
                                                                                            $thisMaxvalue = ((int)$thisalue >= (int)$thisMinvalue) ? $thisalue : $thisMinvalue;
                                                                                            array_push($display_min_array, $thisMinvalue);
                                                                                            array_push($display_max_array, $thisMaxvalue);
                                                                                            ?>
                                                                                            <input type="number" class="form-control minKeyvalue" data-id="min-input<?php echo $key; ?>" value="<?php echo $thisMinvalue; ?>" name="minKeyvalue[]">
                                                                                            <span class="lasykeyplus">+</span>
                                                                                            <span class="lasykeyminus" style="display:none;">-</span>
                                                                                            <input type="hidden" class="form-control lastkey maxKeyvalue" data-this='true3' data-id="max-input<?php echo $key; ?>" value="<?php echo $thisMinvalue; ?>" name="maxKeyvalue[]">
                                                                                        </div>
                                                                                    <?php
                                                                                }
                                                                            } else {

                                                                                if ($fmax != null && $fmin != null) {
                                                                                    ?>
                                                                                        <div class="colorBoxm">
                                                                                            <label for="">Key color <?php echo $count; ?></label>
                                                                                            <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $color; ?>" />
                                                                                            <input type="color" class="colorInput" name="color[]" onchange="colorChange(this)" id="colors" value="<?php echo $color; ?>" />
                                                                                            <span><?php
                                                                                                    $fminNew = $fmaxNew - $avg;
                                                                                                    // if($count == count($colorArray) - 1){
                                                                                                    // $fminNew = $fmin;
                                                                                                    // }
                                                                                                    // echo $fminNew.' - '.$fmaxNew;
                                                                                                    ?>
                                                                                                <div class="color-min-max">
                                                                                                    <?php
                                                                                                    array_push($display_min_array, isset($min_key_values[$key]) ? $min_key_values[$key] : $fminNew);
                                                                                                    array_push($display_max_array, isset($max_key_values[$key]) ? $max_key_values[$key] : $fmaxNew);
                                                                                                    ?>
                                                                                                    <input type="number" class="form-control minKeyvalue" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_key_values[$key]) ? $min_key_values[$key] : $fminNew; ?>" name="minKeyvalue[]">
                                                                                                    <span>-</span>

                                                                                                    <input type="number" class="form-control maxKeyvalue" max-id="min-input<?php echo $key; ?>" value="<?php echo isset($max_key_values[$key]) ? $max_key_values[$key] : $fmaxNew; ?>" name="maxKeyvalue[]">
                                                                                                </div>
                                                                                            <?php
                                                                                            $fmaxNew = $fmaxNew - $avg;
                                                                                        } else {
                                                                                            ?>
                                                                                                <div class="colorBoxm">
                                                                                                    <label for="">Key color <?php echo $count; ?></label>
                                                                                                    <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $color; ?>" />
                                                                                                    <input type="color" class="colorInput" name="color[]" onchange="colorChange(this)" id="colors" value="<?php echo $color; ?>" />
                                                                                                    <span><?php
                                                                                                            // echo $maxNew.' - '.$max;
                                                                                                            ?>
                                                                                                        <div class="color-min-max">
                                                                                                            <?php
                                                                                                            array_push($display_min_array, isset($min_key_values[$key]) ? $min_key_values[$key] : $maxNew);
                                                                                                            array_push($display_max_array, isset($max_key_values[$key]) ? $max_key_values[$key] : $max);
                                                                                                            ?>
                                                                                                            <input type="number" class="form-control minKeyvalue" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_key_values[$key]) ? $min_key_values[$key] : $maxNew; ?>" name="minKeyvalue[]">
                                                                                                            <span>-</span>
                                                                                                            <input type="number" class="form-control maxKeyvalue" data-id="max-input<?php echo $key; ?>" value="<?php echo isset($max_key_values[$key]) ? $max_key_values[$key] : $max; ?>" name="maxKeyvalue[]">
                                                                                                        </div>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                                ?>

                                                                                                <?php

                                                                                                $max = $max - $avgDiff;

                                                                                                ?>
                                                                                                    </span>
                                                                                                    <?php if ($count == count($colorArray)) { ?>

                                                                                                        <button class="removeBoxm" onclick="removeColorm(this,<?php echo $dataMin['min'] . ',' . $dataMax['max']; ?>,<?php if ($fmin != null) {
                                                                                                                                                                                                                        echo $fmin;
                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                        echo 'false';
                                                                                                                                                                                                                    }  ?>,<?php if ($fmax != null) {
                                                                                                                                                                                                                                                                                        echo $fmax;
                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                        echo 'false';
                                                                                                                                                                                                                                                                                    }  ?>)">
                                                                                                            <img src="/uploads/close.png" alt="">
                                                                                                        </button>
                                                                                                    <?php } ?>
                                                                                                </div>
                                                                                            <?php }
                                                                                            ?>
                                                                                        </div><?php
                                                                                            }
                                                                                        }
                                                                                    } //else end


                                                                                                ?>
                                                                            <div class="m-5" id="addBtnBoxm" style="<?php if ($count < 10) { ?>display:block<?php } else {
                                                                                                                                                            echo 'display:none';
                                                                                                                                                        } ?>">
                                                                                <?php $colorArra = json_encode($colorArray);

                                                                                ?>

                                                                                <button type="button" class="btn register-link" id="addColorBtnm" onclick='addColorm(<?php echo $dataMin['min'] . ',' . $dataMax['max'];  ?>,<?php echo $colorArra; ?>,<?php if ($fmin != null) {
                                                                                                                                                                                                                                                        echo 'true';
                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                        echo 'false';
                                                                                                                                                                                                                                                    } ?>,<?php if ($fmax != null) {
                                                                                                                                                                                                                                                                                                                        echo 'true';
                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                        echo 'false';
                                                                                                                                                                                                                                                                                                                    } ?>)'>Add color</button>
                                                                            </div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                                <?php

                                                                $min_display_values = isset($profieldData['min_display_values']) ?  unserialize($profieldData['min_display_values']) : null;
                                                                $max_display_values = isset($profieldData['max_display_values']) ? unserialize($profieldData['max_display_values']) : null;

                                                                ?>
                                                                <div class="col-md-12">
                                                                    <div class="form-group display-range">
                                                                        <div class="dtfield">
                                                                            <h5>Display Ranges</h5>
                                                                        </div>
                                                                        <div class="map-key d-flex">
                                                                            <?php
                                                                            if ($colorArray != null) {
                                                                                $count = 0;
                                                                                if ($ftype == 'Text') {
                                                                                    foreach ($display_max_array as $key => $value) {
                                                                            ?>
                                                                                        <div class="map-val">
                                                                                            <div class="bar" style="height:20px !important; background:<?php echo isset($colorArray[$key]) ? $colorArray[$key] : '#000000'; ?>"></div>
                                                                                            <div class="bar-input">
                                                                                                <input type="hidden" class="form-control min-display" data-id="min-input<?php echo $key; ?>" value="" name="min-display[]">
                                                                                                <input type="text" class="form-control max-display" data-id="max-input<?php echo $key; ?>" value="<?php echo isset($max_display_values[$key]) ? $max_display_values[$key] : $display_max_array[$key]; ?>" name="max-display[]">
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }
                                                                                } else {
                                                                                    foreach ($colorArray as $key => $color) {
                                                                                        $count++;
                                                                                        if ($count == 1) { ?>
                                                                                            <div class="map-val">
                                                                                                <div class="bar" style="height:20px !important; background:<?php echo $color; ?>"></div>
                                                                                                <div class="bar-input">
                                                                                                    <?php
                                                                                                    $check = isset($min_display_values[$key]) ? $min_display_values[$key] : $display_min_array[$key];
                                                                                                    if ($check === 'false') {
                                                                                                    ?>
                                                                                                        <input type="hidden" class="form-control min-display" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_display_values[$key]) ? $min_display_values[$key] : $display_min_array[$key]; ?>" name="min-display[]">
                                                                                                        <!-- <span>-</span> -->
                                                                                                        <input type="text" class="form-control max-display" data-id="max-input<?php echo $key; ?>" value="<?php echo isset($max_display_values[$key]) ? $max_display_values[$key] : $display_max_array[$key]; ?>" name="max-display[]">

                                                                                                    <?php
                                                                                                    } else if ($show_last_key == 'Yes' || $key_value_option == 'Equal Count') { 
                                                                                                        $thisMinvalue = isset($min_display_values[$key]) ? $min_display_values[$key] : $display_min_array[$key];
                                                                                                        $thisalue = isset($max_display_values[$key]) ? $max_display_values[$key] : $display_max_array[$key];
                                                                                                        $thisMaxvalue = ((int)$thisalue >= (int)$thisMinvalue) ? $thisalue : $thisMinvalue;
                                                                                                        ?>
                                                                                                        <input type="text" class="form-control min-display" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_display_values[$key]) ? $min_display_values[$key] : $display_min_array[$key]; ?>" name="min-display[]">
                                                                                                        <span class="lasykeyplus" style="display:none;">+</span>
                                                                                                        <span class="lasykeyminus">-</span>
                                                                                                        <input type="text" class="form-control lastkey max-display" data-this='true4' data-id="max-input<?php echo $key; ?>" value="<?php echo $thisMaxvalue; ?>" name="max-display[]">

                                                                                                    <?php  } else { 
                                                                                                          $thisMinvalue = isset($min_display_values[$key]) ? $min_display_values[$key] : $display_min_array[$key];
                                                                                                          $thisalue =isset($max_display_values[$key]) ? $max_display_values[$key] : $lastkeymaxvalue;
                                                                                                          $thisMaxvalue = ((int)$thisalue >= (int)$thisMinvalue) ? $thisalue : $thisMinvalue;
                                                                                                        ?>
                                                                                                        <input type="text" class="form-control min-display" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_display_values[$key]) ? $min_display_values[$key] : $display_min_array[$key]; ?>" name="min-display[]">
                                                                                                        <span class="lasykeyplus">+</span>
                                                                                                        <span class="lasykeyminus" style="display:none;">-</span>
                                                                                                        <input type="hidden" class="form-control lastkey max-display" data-this='true5' data-id="max-input<?php echo $key; ?>" value="<?php echo $thisMaxvalue; ?>" name="max-display[]">
                                                                                                    <?php }
                                                                                                    ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        <?php
                                                                                        } else { ?>
                                                                                            <div class="map-val">
                                                                                                <div class="bar" style="height:20px !important; background:<?php echo $color; ?>"></div>
                                                                                                <div class="bar-input">
                                                                                                    <?php
                                                                                                    $check = isset($min_display_values[$key]) ? $min_display_values[$key] : $display_min_array[$key];
                                                                                                    if ($check === 'false') { ?>
                                                                                                        <input type="hidden" class="form-control min-display" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_display_values[$key]) ? $min_display_values[$key] : $display_min_array[$key]; ?>" name="min-display[]">
                                                                                                        <!-- <span>-</span> -->
                                                                                                        <input type="text" class="form-control max-display" data-id="max-input<?php echo $key; ?>" value="<?php echo isset($max_display_values[$key]) ? $max_display_values[$key] : $display_max_array[$key]; ?>" name="max-display[]">

                                                                                                    <?php } else {
                                                                                                    ?>
                                                                                                        <input type="text" class="form-control min-display" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_display_values[$key]) ? $min_display_values[$key] : $display_min_array[$key]; ?>" name="min-display[]">
                                                                                                        <span>-</span>
                                                                                                        <input type="text" class="form-control max-display" data-id="max-input<?php echo $key; ?>" value="<?php echo isset($max_display_values[$key]) ? $max_display_values[$key] : $display_max_array[$key]; ?>" name="max-display[]">
                                                                                                    <?php } ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        <?php }
                                                                                        ?>

                                                                            <?php
                                                                                    }
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                            <h5>Reset display range</h5>
                                                                            <input type="button" name="save_display_range" id="save_display_range" data-value="no" class="btn btn-success" value="Reset" />
                                                                    </div>
                                                                </div>
                                                               <div class="col-md-12 df-update-btn text-center">
                                                                    <button type="button" id="datafield_btn_update" class="btn cus-btn" onclick="mapKeyBtnUpdate()">Update</button>
                                                               </div>
            </form>

            <div class="messagenew"></div>
        </div>
        <script>
            $('#colorm_type1').hide();
        </script>
    <?php
        //end
    }
    function updatemapkey()
    {

        $first_interval = $_POST['f_interval'];
        $last_interval = $_POST['l_interval'];
        $id = $_POST['id'];
        $proid = $_POST['proid'];

        $colors = $_POST['color'];
        if ($colors != null) {

            $colors = serialize($colors);
        }

        $key_value_option = isset($_POST['key_value_option']) ? $_POST['key_value_option'] : 'Equal Ranges';
        $link_values = isset($_POST['link_values']) && $_POST['link_values'] == 'Yes' ? $_POST['link_values'] : null;
        $show_last_key = isset($_POST['show_last_key']) && $_POST['show_last_key'] == 'Yes' ? $_POST['show_last_key'] : null;

        $maxKeyvalue = isset($_POST['maxKeyvalue']) ? $_POST['maxKeyvalue'] : null;
        $max_key_values = isset($maxKeyvalue) ? serialize($maxKeyvalue) : null;

        $minKeyvalue = isset($_POST['minKeyvalue']) ? $_POST['minKeyvalue'] : null;
        $min_key_values = isset($minKeyvalue) ? serialize($minKeyvalue) : null;
        $minDisplay = isset($_POST['min-display']) ? $_POST['min-display'] : null;
        $minDisplay_values = isset($minDisplay) ? serialize($minDisplay) : null;
        $maxDisplay = isset($_POST['max-display']) ? $_POST['max-display'] : null;
        $maxDisplay_values = isset($maxDisplay) ? serialize($maxDisplay) : null;



        $sqlUpdateQuery = $this->model->setInterval($first_interval, $last_interval, $colors, $max_key_values, $min_key_values, $key_value_option, $link_values, $show_last_key, $minDisplay_values, $maxDisplay_values, $id);

        $sqlUpdateQuery2 = $this->model->setchildrenInterval($first_interval, $last_interval, $colors, $max_key_values, $min_key_values, $key_value_option, $link_values, $show_last_key, $minDisplay_values, $maxDisplay_values, $id);

        if ($sqlUpdateQuery) {
            echo json_encode(array('success' => 1, 'msg' => 'Map key updated successfully.', 'fid' => $id, 'pid' => $proid));
        } else {
            echo json_encode(array('success' => 0, 'msg' => 'something went wrong!', 'fid' => $id, 'pid' => $proid));
        }
    }
    function getprojectfieldsvalue()
    {
        //start
        $pid = $_POST['proid'];
        $cid = $_POST['cid'];

        $datas = $this->model->getFieldvalueByCityId($cid, $pid);
        $sdata = $this->model->getDataFieldsByIdWithoutGroup($pid);

    ?>
        <form action="javascript:void(0)" id="dataFieldsvalue" class="edit-project" method="post">
            <?php
            $uarray = array();
            $mainarray = array();
            foreach ($datas as $da) {
                foreach ($sdata as $d) {
                    if ($d['id_project_field'] == $da['field_id']) {
                        $obj = new stdClass();
                        $obj->fieldid = $d['id_project_field'];
                        $obj->fieldname = $d['field_name'];
                        $obj->fieldvalue = $da['field_value'];
                        $obj->fieldtype = $d['field_type'];
                        $obj->id = $da['id'];
                        array_push($mainarray, $obj);
                    }
                }
            }

            foreach ($mainarray as $data) {


                $inputtype = $data->fieldtype;
                if ($inputtype == 'Text' || $inputtype == 'Hyperlink') {
                    $itype = 'text';
                } else {
                    $itype = 'number';
                }
            ?>
                <div class="form-group">
                    <label for=""><?php echo $data->fieldname;  ?></label>

                    <input type="<?php echo $itype; ?>" class="form-control myUniqueClass" name="<?php echo $data->fieldid;  ?>" id="<?php echo $data->fieldname;  ?>" data-id="<?php echo $data->id; ?>" value="<?php echo $data->fieldvalue;  ?>">
                </div>

            <?php
            }
            ?>
            <input type="hidden" name="project_id" value="<?php echo $pid; ?>" />
            <input type="hidden" name="city_id" value="<?php echo $cid; ?>" />
            <div class="modal-footer text-center">
                <button type="button" id="updateProjectsFieldvalue" name="submit" value="submit" class="btn cus-btn">Submit </button><img id="loaderedit" style="display:none" src="../images/ajax-loader.gif">
            </div>
        </form>
        <?php
        //end
    }
    function updatecountryfieldvalue()
    {
        $cid = $_POST['city_id'];
        $pid = $_POST['project_id'];

        foreach ($_POST as $key => $value) {
            if ($key != 'city_id' && $key != 'project_id') {
                $sdata = $this->model->updateFieldalue($value, $pid, $cid, $key);
            }
        }
        echo json_encode(array('success' => 1, 'msg' => 'Field value updated successfully.'));
    }
    function getallcolor()
    {
        //start
        $colorArray = $_POST['color'];
        $countAllColor = count($colorArray);
        $min = $_POST['min'];
        $max = $_POST['max'];

        $constant_min = $_POST['min'];

        if (!empty($max) && empty($min)) {
            $min = '0';
            $constant_min = '0';
        }

        $fmin = $_POST['fmin'];
        $fmax = $_POST['fmax'];
        if (empty($fmin)) {
            $fmin = 'false';
        }
        if (empty($fmax)) {
            $fmax = 'false';
        }
        $id = $_POST['projectfield_id'];
        $dataMaximum = $this->model->maxfieldValue($id);
        $dataMax = $dataMaximum[0];
        $lastkeymaxvalue = $dataMax['max'];
        $profieldDatas = $this->model->getDataFieldsByFieldId($id);
        $profieldData = $profieldDatas[0];

        if ($fmin != 'false' && $fmax != 'false') {
            $fmaxNew  = $max;
            $nCount = $countAllColor - 1;
            $avg = round(($_POST['max'] - $_POST['min']) / $nCount, 2);
            $avgDiff = $avg;
        } else if ($fmin == 'false' && $fmax != 'false') {
            $fmaxNew  = $max;
            $nCount = $countAllColor - 1;
            $avg = round(($_POST['max'] - $_POST['min']) / $nCount, 2);
            $avgDiff = $avg;
        } else {
            $avg = round(($_POST['max'] - $_POST['min']) / $countAllColor, 2);
            $avgDiff = $avg;
        }
        $max_key_values = isset($profieldData['max_key_values']) ? unserialize($profieldData['max_key_values']) : null;
        $min_key_values = isset($profieldData['min_key_values']) ? unserialize($profieldData['min_key_values']) : null;

        $key_value_option = $profieldData['key_value_option'];
        $counttotalvalue = $this->model->countfieldValue($id);
        $counttotal = $counttotalvalue[0];
        $color_count = count($colorArray);

        $show_last_key = $profieldData['show_last_key'];
        if ($show_last_key == 'Yes') {
        ?>
            <script>
                $('.lastkey').attr('type', 'text');
                $('.lasykeyplus').hide();
                $('.lasykeyminus').show();
            </script>
        <?php
        }

        if ($key_value_option == 'Equal Ranges') {
        ?>
            <script>
                $('.minKeyvalue').attr('readonly', true);
                $('.maxKeyvalue').attr('readonly', true);
                $('#l_interval').removeAttr('readonly');
                $('#f_interval').removeAttr('readonly');
            </script>
        <?php
        } else if ($key_value_option == 'Custom Ranges') {
        ?>
            <script>
                $('.minKeyvalue').removeAttr('readonly');
                $('.maxKeyvalue').removeAttr('readonly');
                $('#l_interval').attr('readonly', true);
                $('#f_interval').attr('readonly', true);
            </script>
        <?php
        } else if ($key_value_option == 'Equal Count') {
        ?>
            <script>
                $('.minKeyvalue').attr('readonly', true);
                $('.maxKeyvalue').attr('readonly', true);
                $('#l_interval').attr('readonly', true);
                $('#f_interval').attr('readonly', true);
            </script>
        <?php
        }

        $ftype = $profieldData['field_type'];
        $data_field_value = $this->model->select_data_field_value_by_fid($id);
        $UniqueArray = array();
        foreach ($data_field_value as $dfv) {
            if ($dfv['field_value'] && $dfv['field_value'] != null) {
                $trimval = trim($dfv['field_value']);
                if (!in_array($trimval, $UniqueArray)) {
                    array_push($UniqueArray, $trimval);
                }
            }
        }
        $UniqueArray = array_unique($UniqueArray);

        ?>
        <div class="color-append-boxm">
            <label for="">Key colors:</label>
            <?php if ($ftype == 'Text') {
                if ($max_key_values != null && count($max_key_values) > 0) {
                    $UniqueArray = $max_key_values;
                }
                $count = 0;
                $uniqueCount = count($UniqueArray);
                foreach ($colorArray as $key => $color) {
                    if ($count < 10) {
                        $count++;  ?>
                        <div class="colorBoxm">
                            <label for="">Key color <?php echo $count; ?></label>
                            <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo isset($colorArray[$key]) ? $colorArray[$key] : '#000000'; ?>" />
                            <input type="color" class="colorInput" name="color[]" onchange="colorChange(this)" id="colors" value="<?php echo isset($colorArray[$key]) ? $colorArray[$key] : '#000000'; ?>" />
                            <div class="color-min-max">
                                <input type="hidden" class="form-control minKeyvalue" value="" name="minKeyvalue[]">
                                <input type="text" class="form-control maxKeyvalue" value="<?php echo isset($max_key_values[$key]) ? $max_key_values[$key] : (isset($UniqueArray[$key]) ? $UniqueArray[$key] : '0'); ?>" name="maxKeyvalue[]">
                            </div>
                            <?php
                            if (count($colorArray) == $count || $count == 10) {
                            ?>
                                <button class="removeBoxm" onclick="removeColorm(this,0,0,false,false)">
                                    <img src="/uploads/close.png" alt="">
                                </button>
                            <?php }
                            ?>
                        </div>
                        <?php
                    }
                }
            } else {
                if ($key_value_option == 'Equal Count') {
                    if ($colorArray != null) {
                        $count = 0;
                        $from = 0;
                        $to = round($counttotal['total'] / $color_count);
                        $devide = round($counttotal['total'] / $color_count);

                        $px = $this->model->getEqualCountvalueswithIgnore($id);
                        rsort($px);
                        $newCOUNT =  count($px);
                        $NEW_devide = round($newCOUNT / $color_count);
                        $main_array = array();
                        $arr = array();
                        $fff = 0;
                        $fff_1 = 0;
                        $NEW_devide_1 = round($newCOUNT / $color_count);
                        $allworked = true;
                        if ($newCOUNT > $color_count) {
                            foreach ($colorArray as $key => $color) {
                                $E_Arr = $this->model->getEqualCountvaluesV2($id, $fff_1, $NEW_devide_1);
                                if(!empty($E_Arr)){
                                    $arr = [min($E_Arr), max($E_Arr)];
                                    if(in_array($arr, $main_array)){
                                        $allworked = false;
                                            }
                                    array_push($main_array, $arr);
                                    $arr = array();
                                }else{
                                    $allworked = false;
                                }
                                if(min($E_Arr)==max($E_Arr)){
                                    $allworked = false;
                                }
                                if ($key == ($color_count - 2)) {
                                    $fff_1 = $fff_1 + $NEW_devide_1;
                                    $NEW_devide_1 = $NEW_devide_1 + ($newCOUNT - ($NEW_devide_1 * $color_count));
                                } else {
                                    $fff_1 = $fff_1 + $NEW_devide_1;
                                }
                            }
                        } else {
                            $allworked = false;
                        }
                        // if ($newCOUNT > $color_count && $allworked == true) {
                            if ($newCOUNT > $color_count) {
                        foreach ($colorArray as $key => $color) {
                            $Equalcount_array = $this->model->getEqualCountvaluesV2($id, $fff, $NEW_devide);

                            if ($count < 10) {
                                $count++;  ?>
                                <div class="colorBoxm">
                                    <label for="">Key color <?php echo $count; ?></label>
                                    <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo isset($colorArray[$key]) ? $colorArray[$key] : '#000000'; ?>" />
                                    <input type="color" class="colorInput" name="color[]" onchange="colorChange(this)" id="colors" value="<?php echo isset($colorArray[$key]) ? $colorArray[$key] : '#000000'; ?>" />
                                    <div class="color-min-max">
                                        <?php
                                        $thisMinvalue = min($Equalcount_array);
                                        $thisalue = max($Equalcount_array);
                                        $thisMaxvalue = ((int)$thisalue >= (int)$thisMinvalue) ? $thisalue : $thisMinvalue;
                                        if ($count == 1) { ?>
                                            <input type="number" class="form-control minKeyvalue" data-id="min-input<?php echo $key; ?>" value="<?php echo min($Equalcount_array); ?>" name="minKeyvalue[]">
                                            <span class="lasykeyplus" style="display:none;">+</span>
                                            <span class="lasykeyminus">-</span>
                                            <input type="number" class="form-control lastkey maxKeyvalue" data-id="max-input<?php echo $key; ?>" value="<?php echo $thisMaxvalue; ?>" name="maxKeyvalue[]">
                                        <?php } else {
                                        ?>
                                            <input type="number" class="form-control minKeyvalue" data-id="min-input<?php echo $key; ?>" value="<?php echo min($Equalcount_array); ?>" name="minKeyvalue[]">
                                            <span>-</span>
                                            <input type="number" class="form-control maxKeyvalue" data-id="max-input<?php echo $key; ?>" value="<?php echo $thisMaxvalue; ?>" name="maxKeyvalue[]">
                                        <?php } ?>
                                    </div>
                                    <?php
                                    if ($color_count == $count || $count == 10) {
                                    ?>
                                        <button class="removeBoxm" onclick="removeColorm(this,0,0,false,false)">
                                            <img src="/uploads/close.png" alt="">
                                        </button>
                                    <?php }
                                    ?>
                                </div>
                            <?php
                            }

                            if ($key == ($color_count - 2)) {
                                $fff = $fff + $NEW_devide;
                                $NEW_devide = $NEW_devide + ($newCOUNT - ($NEW_devide * $color_count));
                            } else {
                                $fff = $fff + $NEW_devide;
                            }
                        }
                    }else{
                        ?>
                        <script>
                                Swal.fire({
                                    icon: 'error',
                                    customClass: 'swal-wide',
                                    title: "Invalid Equal count, instead choose custom range option.",showConfirmButton: true,onClose: () => {
                                            $("input[name=key_value_option][value='Custom Ranges']").prop("checked",true);
                                        mapKeyBtnUpdate();
                                                }
                                            });
                        </script>
                
                        <?php

                    }

                        
                    }
                } else {


                    if ($colorArray != null) {
                        $count = 0;
                        if ($key_value_option == 'Equal Ranges') {
                            $min_key_values = null;
                            $max_key_values = null;
                        }
                        foreach ($colorArray as $key => $color) {
                            $count++;
                            ?>
                            <div class="colorBoxm">
                                <label for="">Key color <?php echo $count; ?></label>
                                <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $color; ?>" />
                                <input type="color" class="colorInput" name="color[]" onchange="colorChange(this)" id="colors" value="<?php echo $color; ?>" />


                                <span><?php
                                        $maxNew  = $max - $avgDiff;
                                        if ($count == count($colorArray)) {
                                            if ($fmin != 'false') {
                                                //  echo '0'.' - '.$min; 
                                                $fm = $min + $avgDiff;
                                        ?>
                                            <div class="color-min-max">
                                                <input type="number" class="form-control minKeyvalue" data-id="min-input<?php echo $key; ?>" value="<?php echo $constant_min; ?>" name="minKeyvalue[]">
                                                <span>-</span>
                                                <input type="number" class="form-control maxKeyvalue" data-id="max-input<?php echo $key; ?>" value="<?php echo isset($max_key_values[$key]) ? $max_key_values[$key] : $fm; ?>" name="maxKeyvalue[]">
                                            </div>
                                        <?php
                                            } else {
                                                //  echo $min.' - '.$max; 

                                        ?>
                                            <div class="color-min-max">

                                                <input type="number" class="form-control minKeyvalue" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_key_values[$key]) ? $min_key_values[$key] : $min; ?>" name="minKeyvalue[]">
                                                <span>-</span>
                                                <input type="number" class="form-control maxKeyvalue" data-id="max-input<?php echo $key; ?>" value="<?php echo isset($max_key_values[$key]) ? $max_key_values[$key] : $max; ?>" name="maxKeyvalue[]">
                                            </div>

                                        <?php
                                            }

                                        ?>
                                        <!-- <input type="hidden" value="<?php //echo $min; 
                                                                            ?>" name="min<?php /// echo $count; 
                                                                                                            ?>"> -->
                                        <!-- <input type="hidden" value="<?php // echo $max; 
                                                                            ?>" name="max<?php //echo $count; 
                                                                                                            ?>"> -->
                                        <?php

                                        } else if ($count == 1) {
                                            if ($fmax != 'false') {
                                                //    echo $max.'+';
                                                if ($fmax == true) {
                                                    $fmax = $max;
                                                }

                                                $thisMinvalue = isset($min_key_values[$key]) ? $min_key_values[$key] : ($fmax ? $fmax : $max - $avg); 
                                                $thisalue = isset($max_key_values[$key]) ? $max_key_values[$key] : $lastkeymaxvalue;
                                                $thisMaxvalue = ((int)$thisalue >= (int)$thisMinvalue) ? $thisalue : $thisMinvalue;
                                        ?>

                                            <div class="color-min-max">
                                                <input type="number" class="form-control minKeyvalue" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_key_values[$key]) ? $min_key_values[$key] : ($fmax ? $fmax : $max - $avg); ?>" name="minKeyvalue[]">
                                                <span class="lasykeyplus">+</span>
                                                <span class="lasykeyminus" style="display:none;">-</span>
                                                <input type="hidden" class="form-control lastkey maxKeyvalue" data-id="max-input<?php echo $key; ?>" value="<?php echo $thisMaxvalue; ?>" name="maxKeyvalue[]">
                                            </div>
                                        <?php
                                            } else {
                                                $thisMinvalue = isset($min_key_values[$key]) ? $min_key_values[$key] : ($maxNew ? $maxNew : $max - $avg);
                                                $thisalue = isset($max_key_values[$key]) ? $max_key_values[$key] : $lastkeymaxvalue;
                                                $thisMaxvalue = ((int)$thisalue >= (int)$thisMinvalue) ? $thisalue : $thisMinvalue;
                                                //  echo $maxNew.'+';  
                                        ?>

                                            <div class="color-min-max">
                                                <input type="number" class="form-control minKeyvalue" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_key_values[$key]) ? $min_key_values[$key] : ($maxNew ? $maxNew : $max - $avg); ?>" name="minKeyvalue[]">
                                                <span class="lasykeyplus">+</span>
                                                <span class="lasykeyminus" style="display:none;">-</span>
                                                <input type="hidden" class="form-control lastkey maxKeyvalue" data-id="max-input<?php echo $key; ?>" value="<?php echo $thisMaxvalue; ?>" name="maxKeyvalue[]">
                                            </div>
                                        <?php
                                            }
                                        } else {
                                            if ($fmax != 'false' && $fmin != 'false') {
                                                $fminNew  = $fmaxNew - $avg;

                                                //     if($count == count($colorArray) - 1){
                                                //       $fminNew = $min;
                                                //   }
                                                // echo $fminNew.' - '.$fmaxNew;
                                        ?>
                                            <div class="color-min-max">

                                                <input type="number" class="form-control minKeyvalue" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_key_values[$key]) ? $min_key_values[$key] : $fminNew; ?>" name="minKeyvalue[]">
                                                <span>-</span>
                                                <input type="number" class="form-control maxKeyvalue" data-id="max-input<?php echo $key; ?>" value="<?php echo isset($max_key_values[$key]) ? $max_key_values[$key] : $fmaxNew; ?>" name="maxKeyvalue[]">
                                            </div>

                                        <?php
                                                $fmaxNew  = $fmaxNew - $avg;
                                            } else {
                                                // echo $maxNew.' - '.$max;
                                        ?>
                                            <div class="color-min-max">

                                                <input type="number" class="form-control minKeyvalue" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_key_values[$key]) ? $min_key_values[$key] : $maxNew; ?>" name="minKeyvalue[]">
                                                <span>-</span>
                                                <input type="number" class="form-control maxKeyvalue" data-id="max-input<?php echo $key; ?>" value="<?php echo isset($max_key_values[$key]) ? $max_key_values[$key] : $max; ?>" name="maxKeyvalue[]">
                                            </div>

                                        <?php
                                            }

                                        ?>
                                        <!-- <input type="hidden" value="<?php // echo $maxNew; 
                                                                            ?>" name="min<?php //echo $count; 
                                                                                                                ?>"> -->
                                        <!-- <input type="hidden" value="<?php //echo $max; 
                                                                            ?>" name="max<?php //echo $count; 
                                                                                                            ?>"> -->
                                    <?php
                                        }
                                    ?> <?php
                            $max = $max - $avgDiff;
                        ?>
                                </span>
                                <?php if ($count == count($colorArray)) { ?>

                                    <button class="removeBoxm" onclick="removeColorm(this,<?php echo $_POST['min']; ?>,<?php echo $_POST['max']; ?>,<?php echo $fmin; ?>,<?php echo $fmax; ?>)">
                                        <img src="/uploads/close.png" alt="">
                                    </button>
                                <?php } ?>
                            </div>
            <?php }
                    }
                }
            }
            ?>
        </div>
        <div class="m-5" id="addBtnBoxm" style="<?php if ($count < 10) { ?>display:block<?php } else {
                                                                                        echo 'display:none';
                                                                                    } ?>">
            <?php $colorArra = json_encode($colorArray); ?>
            <button type="button" class="btn register-link" id="addColorBtnm" onclick='addColorm(<?php echo $_POST["min"] . "," . $_POST["max"];  ?>,<?php echo $colorArra; ?>,<?php echo $fmin; ?>,<?php echo $fmax; ?>)'>Add color</button>
        </div>

        <?php
        //end
    }
    function getDisplaycolor()
    {
        //start
        $colorArray = $_POST['color'];
        $countAllColor = count($colorArray);
        $min = $_POST['min'];
        $constant_min = $_POST['min'];
        $max = $_POST['max'];

        if (!empty($max) && empty($min)) {
            $min = '0';
            $constant_min = '0';
        }

        $fmin = $_POST['fmin'];
        $fmax = $_POST['fmax'];
        if (empty($fmin)) {
            $fmin = 'false';
        }
        if (empty($fmax)) {
            $fmax = 'false';
        }
        $id = $_POST['projectfield_id'];
        $dataMaximum = $this->model->maxfieldValue($id);
        $dataMax = $dataMaximum[0];
        $lastkeymaxvalue = $dataMax['max'];
        $profieldDatas = $this->model->getDataFieldsByFieldId($id);
        $profieldData = $profieldDatas[0];

        if ($fmin != 'false' && $fmax != 'false') {
            $fmaxNew  = $max;
            $nCount = $countAllColor - 1;
            $avg = round(($_POST['max'] - $_POST['min']) / $nCount, 2);
            $avgDiff = $avg;
        } else if ($fmin == 'false' && $fmax != 'false') {
            $fmaxNew  = $max;
            $nCount = $countAllColor - 1;
            $avg = round(($_POST['max'] - $_POST['min']) / $nCount, 2);
            $avgDiff = $avg;
        } else {
            $avg = round(($_POST['max'] - $_POST['min']) / $countAllColor, 2);
            $avgDiff = $avg;
        }
        $max_key_values = isset($profieldData['max_key_values']) ? unserialize($profieldData['max_key_values']) : null;
        $min_key_values = isset($profieldData['min_key_values']) ? unserialize($profieldData['min_key_values']) : null;

        $key_value_option = $profieldData['key_value_option'];
        $counttotalvalue = $this->model->countfieldValue($id);
        $counttotal = $counttotalvalue[0];
        $color_count = count($colorArray);

        $show_last_key = $profieldData['show_last_key'];
        if ($show_last_key == 'Yes') {
        ?>
            <script>
                $('.lastkey').attr('type', 'text');
                $('.lasykeyplus').hide();
                $('.lasykeyminus').show();
            </script>
            <?php
        }

        // $min_display_values = isset($profieldData['min_display_values']) ?  unserialize($profieldData['min_display_values']) : null;
        // $max_display_values = isset($profieldData['max_display_values']) ? unserialize($profieldData['max_display_values']) : null;
        $min_display_values = $min_key_values;
        $max_display_values = $max_key_values;

        $ftype = $profieldData['field_type'];
        $data_field_value = $this->model->select_data_field_value_by_fid($id);
        $UniqueArray = array();
        foreach ($data_field_value as $dfv) {
            if ($dfv['field_value'] && $dfv['field_value'] != null) {
                $trimval = trim($dfv['field_value']);
                if (!in_array($trimval, $UniqueArray)) {
                    array_push($UniqueArray, $trimval);
                }
            }
        }
        $UniqueArray = array_unique($UniqueArray);

        if ($ftype == 'Text') {
            if ($max_key_values != null && count($max_key_values) > 0) {
                $UniqueArray = $max_key_values;
            }
            $count = 0;
            $uniqueCount = count($UniqueArray);
            foreach ($colorArray as $key => $color) {
                if ($count < 10) {
                    $count++;  ?>
                    <div class="map-val">
                        <div class="bar" style="height:20px !important; background:<?php echo $color; ?>"></div>
                        <div class="bar-input">
                            <input type="hidden" class="form-control min-display" data-id="min-input<?php echo $key; ?>" value="" name="min-display[]">
                            <input type="text" class="form-control max-display" data-id="max-input<?php echo $key; ?>" value="<?php echo isset($max_display_values[$key]) ? $max_display_values[$key] : (isset($UniqueArray[$key]) ? $UniqueArray[$key] : '0'); ?>" name="max-display[]">
                        </div>
                    </div>
                    <?php
                }
            }
        } else {
            if ($key_value_option == 'Equal Count') {
                if ($colorArray != null) {
                    $count = 0;
                    $from = 0;
                    $to = round($counttotal['total'] / $color_count);
                    $devide = round($counttotal['total'] / $color_count);

                    $px = $this->model->getEqualCountvalueswithIgnore($id);
                    rsort($px);
                    $newCOUNT =  count($px);
                    $NEW_devide = round($newCOUNT / $color_count);
                    $main_array = array();
                    $arr = array();
                    $fff = 0;
                    $fff_1 = 0;
                    $NEW_devide_1 = round($newCOUNT / $color_count);
                    $allworked = true;
                    if ($newCOUNT > $color_count) {
                        foreach ($colorArray as $key => $color) {
                            $E_Arr = $this->model->getEqualCountvaluesV2($id, $fff_1, $NEW_devide_1);
                            if(!empty($E_Arr)){
                                $arr = [min($E_Arr), max($E_Arr)];
                                if(in_array($arr, $main_array)){
                                    $allworked = false;
                                        }
                                array_push($main_array, $arr);
                                $arr = array();
                            }else{
                                $allworked = false;
                            }
                            if(min($E_Arr)==max($E_Arr)){
                                $allworked = false;
                            }
                            if ($key == ($color_count - 2)) {
                                $fff_1 = $fff_1 + $NEW_devide_1;
                                $NEW_devide_1 = $NEW_devide_1 + ($newCOUNT - ($NEW_devide_1 * $color_count));
                            } else {
                                $fff_1 = $fff_1 + $NEW_devide_1;
                            }
                        }
                    } else {
                        $allworked = false;
                    }

        // if ($newCOUNT > $color_count && $allworked == true) {
 if ($newCOUNT > $color_count) {
                    foreach ($colorArray as $key => $color) {
                        $Equalcount_array = $this->model->getEqualCountvaluesV2($id, $fff, $NEW_devide);

                        if ($count < 10) {
                            $count++;
                            $thisMinvalue = min($Equalcount_array);
                            $thisalue = max($Equalcount_array);
                            $thisMaxvalue = ((int)$thisalue >= (int)$thisMinvalue) ? $thisalue : $thisMinvalue;

                            if ($count == 1) { ?>

                                <div class="map-val">
                                    <div class="bar" style="height:20px !important; background:<?php echo $color; ?>"></div>
                                    <div class="bar-input">
                                        <input type="text" class="form-control min-display" data-id="min-input<?php echo $key; ?>" value="<?php echo min($Equalcount_array); ?>" name="min-display[]">
                                        <span class="lasykeyplus" style="display:none;">+</span>
                                        <span class="lasykeyminus">-</span>
                                        <input type="text" class="form-control lastkey max-display" data-id="max-input<?php echo $key; ?>" value="<?php echo $thisMaxvalue; ?>" name="max-display[]">
                                    </div>
                                </div>
                            <?php } else {
                            ?>
                                <div class="map-val">
                                    <div class="bar" style="height:20px !important; background:<?php echo $color; ?>"></div>
                                    <div class="bar-input">
                                        <input type="text" class="form-control min-display" data-id="min-input<?php echo $key; ?>" value="<?php echo min($Equalcount_array); ?>" name="min-display[]">
                                        <span class="lasykeyplus" style="display:none;">+</span>
                                        <span class="lasykeyminus">-</span>
                                        <input type="text" class="form-control lastkey max-display" data-id="max-input<?php echo $key; ?>" value="<?php echo $thisMaxvalue; ?>" name="max-display[]">
                                    </div>
                                </div>
                            <?php }
                        }
                     
            if ($key == ($color_count - 2)) {
                $fff = $fff + $NEW_devide;
                $NEW_devide = $NEW_devide + ($newCOUNT - ($NEW_devide * $color_count));
            } else {
                $fff = $fff + $NEW_devide;
            }
                    }
                }else{
                    ?>
                    <script>
                            Swal.fire({
                                icon: 'error',
                                customClass: 'swal-wide',
                                title: "Invalid Equal count, instead choose custom range option.",showConfirmButton: true,onClose: () => {
                                        $("input[name=key_value_option][value='Custom Ranges']").prop("checked",true);
                                    mapKeyBtnUpdate();
                                            }
                                        });
                    </script>
            
                    <?php
                }



                }
            } else {
                if ($colorArray != null) {
                    $count = 0;
                    if ($key_value_option == 'Equal Ranges') {
                        $max_display_values = null;
                        $min_display_values = null;
                    }
                    foreach ($colorArray as $key => $color) {
                        $count++;
                        $maxNew  = $max - $avgDiff;
                        if ($count == count($colorArray)) {
                            if ($fmin != 'false') {

                                $fm = $min + $avgDiff;

                            ?>
                                <div class="map-val">
                                    <div class="bar" style="height:20px !important; background:<?php echo $color; ?>"></div>
                                    <div class="bar-input">
                                        <input type="text" class="form-control min-display" data-id="min-input<?php echo $key; ?>" value="<?php echo $constant_min; ?>" name="min-display[]">
                                        <span>-</span>
                                        <input type="text" class="form-control max-display" data-id="max-input<?php echo $key; ?>" value="<?php echo isset($max_display_values[$key]) ? $max_display_values[$key] : $fm; ?>" name="max-display[]">
                                    </div>
                                </div>
                            <?php
                            } else {
                            ?>

                                <div class="map-val">
                                    <div class="bar" style="height:20px !important; background:<?php echo $color; ?>"></div>
                                    <div class="bar-input">
                                        <input type="text" class="form-control min-display" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_display_values[$key]) ? $min_display_values[$key] : $min; ?>" name="min-display[]">
                                        <span>-</span>
                                        <input type="text" class="form-control max-display" data-id="max-input<?php echo $key; ?>" value="<?php echo isset($max_display_values[$key]) ? $max_display_values[$key] : $max; ?>" name="max-display[]">
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <?php

                        } else if ($count == 1) {
                            if ($fmax != 'false') {
                                if ($fmax == true) {
                                    $fmax = $max;
                                }

                                $thisMinvalue =isset($min_display_values[$key]) ? $min_display_values[$key] : ($fmax ? $fmax : $max - $avg);
                                $thisalue = isset($max_display_values[$key]) ? $max_display_values[$key] : $lastkeymaxvalue; 
                                $thisMaxvalue = ((int)$thisalue >= (int)$thisMinvalue) ? $thisalue : $thisMinvalue;
                            ?>

                                <div class="map-val">
                                    <div class="bar" style="height:20px !important; background:<?php echo $color; ?>"></div>
                                    <div class="bar-input">
                                        <input type="text" class="form-control min-display" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_display_values[$key]) ? $min_display_values[$key] : ($fmax ? $fmax : $max - $avg); ?>" name="min-display[]">
                                        <span class="lasykeyplus" style="<?php echo ($show_last_key == 'Yes') ? 'display:none;' : ''; ?>">+</span>
                                        <span class="lasykeyminus" style="<?php echo ($show_last_key != 'Yes') ? 'display:none;' : ''; ?>">-</span>
                                        <input type="<?php echo ($show_last_key == 'Yes') ? 'text' : 'hidden'; ?>" class="form-control lastkey max-display" data-id="max-input<?php echo $key; ?>" value="<?php echo $thisMaxvalue; ?>" name="max-display[]">
                                    </div>
                                </div>

                            <?php
                            } else {

                                
                                $thisMinvalue =isset($min_display_values[$key]) ? $min_display_values[$key] :($maxNew ? $maxNew : $max - $avg);
                                $thisalue = isset($max_display_values[$key]) ? $max_display_values[$key] : $lastkeymaxvalue; 
                                $thisMaxvalue = ((int)$thisalue >= (int)$thisMinvalue) ? $thisalue : $thisMinvalue;
                            ?>

                                <div class="map-val">
                                    <div class="bar" style="height:20px !important; background:<?php echo $color; ?>"></div>
                                    <div class="bar-input">
                                        <input type="text" class="form-control min-display" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_display_values[$key]) ? $min_display_values[$key] : ($maxNew ? $maxNew : $max - $avg); ?>" name="min-display[]">
                                        <span class="lasykeyplus" style="<?php echo ($show_last_key == 'Yes') ? 'display:none;' : ''; ?>">+</span>
                                        <span class="lasykeyminus" style="<?php echo ($show_last_key != 'Yes') ? 'display:none;' : ''; ?>">-</span>
                                        <input type="<?php echo ($show_last_key == 'Yes') ? 'text' : 'hidden'; ?>" class="form-control lastkey max-display" data-id="max-input<?php echo $key; ?>" value="<?php echo $thisMaxvalue; ?>" name="max-display[]">
                                    </div>
                                </div>
                            <?php
                            }
                        } else {
                            if ($fmax != 'false' && $fmin != 'false') {
                                $fminNew  = $fmaxNew - $avg;

                                // if ($count == count($colorArray) - 1) {
                                //     $fminNew = $min;
                                // }
                            ?>

                                <div class="map-val">
                                    <div class="bar" style="height:20px !important; background:<?php echo $color; ?>"></div>
                                    <div class="bar-input">
                                        <input type="text" class="form-control min-display" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_display_values[$key]) ? $min_display_values[$key] : $fminNew; ?>" name="min-display[]">
                                        <span>-</span>
                                        <input type="text" class="form-control max-display" data-id="max-input<?php echo $key; ?>" value="<?php echo isset($max_display_values[$key]) ? $max_display_values[$key] : $fmaxNew; ?>" name="max-display[]">
                                    </div>
                                </div>

                            <?php
                                $fmaxNew  = $fmaxNew - $avg;
                            } else {
                            ?>
                                <div class="map-val">
                                    <div class="bar" style="height:20px !important; background:<?php echo $color; ?>"></div>
                                    <div class="bar-input">
                                        <input type="text" class="form-control min-display" data-id="min-input<?php echo $key; ?>" value="<?php echo isset($min_display_values[$key]) ? $min_display_values[$key] : $maxNew; ?>" name="min-display[]">
                                        <span>-</span>
                                        <input type="text" class="form-control max-display" data-id="max-input<?php echo $key; ?>" value="<?php echo isset($max_display_values[$key]) ? $max_display_values[$key] : $max; ?>" name="max-display[]">
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        <?php
                        }
                        ?> <?php
                            $max = $max - $avgDiff;
                        }
                    }
                }
            }
        }

         function updateDisplayColor()
        {
        $id = $_POST['projectfield_id'];
        $dataClients = $this->model->updateDisVal($id);
        echo json_encode(array('success' => 1, 'msg' => 'reset display value.'));
        }

        function selectcompany()
        {

            $cid = $_POST['client_id'];
            $cname = $_POST['cname'];
            $_SESSION['cname'] = $cname;

            $dataClients = $this->model->getClientsById($cid);

            if ($cname == 'Select your company') {
                unset($_SESSION['selectid']);

                echo json_encode(array(
                    'success' => 1,
                    'msg' => "No company selected."
                ));
            } else {

                foreach ($dataClients as $dclient) {
                    unset($_SESSION['selectid']);
                    $is_suspended = $dclient['is_suspended'];
                    if ($is_suspended == 1) {
                        echo json_encode(array(
                            'success' => 0,
                            'msg' => "$cname is suspended."
                        ));
                    } else {
                        $_SESSION['selectid'] = $cid;
                        echo json_encode(array(
                            'success' => 1,
                            'msg' => "$cname selected successfully."
                        ));
                    }
                }
            }
        }
        function groupfilter()
        {
            $gid = $_POST['groupid'];
            $_SESSION['groupid'] = $gid;

            $groupData = $this->model->getProjectGroupByID($gid);

            foreach ($groupData as $gdata) {

                if ($gdata != null) {
                    if ($gdata['projects'] != null) {
                        $_SESSION['projectArray'] = unserialize($gdata['projects']);
                    } else {
                        $_SESSION['projectArray'] = 'NO';
                    }
                } else {

                    $_SESSION['projectArray'] = 'NO';
                }
            }

            echo json_encode(array('success' => 1, 'msg' => ''));
        }
        function saveshortingchart()
        {

            if ($_POST['shortposition']) {
                $short_id = $_POST['shortposition'];
                $sequence = $_POST['sequence'];
                $count = 0;
                foreach ($short_id as $id) {

                    $sequenceno = $sequence[$count];
                    $result = $this->model->sortingchartWizard($sequenceno, $id);

                    $count++;
                }
                echo json_encode(array('success' => 1, 'msg' => 'Sorted successfully.', 'redirect_url' => ''));
            }
        }
        function isdatagroup()
        {
            $pdval = $_POST['dvalue'];
            $id = $_POST['id'];
            $restrict_children = $_POST['restrict_children'];
            $result = $this->model->setIsgroupOrnot($pdval, $id,$restrict_children);
        }

        function deletedatafield()
        {
            if ($_GET['id']) {
                $id = $_GET['id'];
                $proId = $_GET['proid'];

                $result = $this->model->deleteprofield($id);
                $result = $this->model->deletefieldval($proId, $id);

                $leftfromgroup = $this->model->leftdatafiledfromGroup($id);

                //
                $key = 'Hl2018@1212';
                $encrypted_id = openssl_encrypt($proId, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
                $encrypted_id = strtolower(bin2hex($encrypted_id));
                            ?>
            <script>
                location.href = '<?php echo BASE_URL; ?>projects/viewprojects/<?php echo $encrypted_id; ?>';
            </script>

<?php
                //
            }
        }
        /*******ADD DATA GROUP********/
        function adddatagroup()
        {
            $gname = $_POST['gname'];
            $cid = $_POST['cid'];
            $pid = $_POST['proid'];
            $datafields = $_POST['datafield'];
            $datatype = $_POST['datatype'];
            $is_node_ranking_group = $_POST['is_node_ranking_group'];
            $invert_node_ranking_group = $_POST['invert_node_ranking_group'];
            $display_on_map_group = $_POST['display_on_map_group'];
            if ($datafields != null) {
                $datafields  = serialize($datafields);
            }
            $added_by = $_SESSION['uid'];
            $result = $this->model->insertDataGroup($gname, $datafields, $added_by, $cid, $datatype, $is_node_ranking_group, $invert_node_ranking_group, $display_on_map_group, $pid);
            $redirectUrl = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : null;
            if ($redirectUrl != null) {
                $redirectUri = $redirectUrl;
            }
            echo json_encode(array('success' => 1, 'msg' => 'Data group added successfully.', 'redirect_url' => $redirectUri));
        }

        /***************/
    }
?>