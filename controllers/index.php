<?php
class Index extends Controller {
	function __construct() {
		parent::__construct();
	}
	
	function index($parm=null){
		$pc=isset($_GET) ? $_GET : null;
		if(empty($parm) && empty($pc)){
			if(isset($_SESSION['uid'])){
					header('Location:'. BASE_URL.'dashboard');
			}else{
			$this->view->show('dashboard/login');
			}
		}else{
		    $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		    if($actual_link=='https://visualisation.polimapper.co.uk/?dataSetKey=aruk-ccg-map'){
		       header('Location:https://visualisation.polimapper.co.uk/?dataSetKey=aruk-ccg-map&client=alzheimersresearch');    
		    } else if($actual_link=='https://visualisation.polimapper.co.uk/?dataSetKey=bctaconstituencies') {
		       header('Location:https://visualisation.polimapper.co.uk/?dataSetKey=bctaconstituencies&client=nathancoyne');    
		    } else if($actual_link=='https://visualisation.polimapper.co.uk/?dataSetKey=aruk-welsh-health-boards') {
		       header('Location:https://visualisation.polimapper.co.uk/?dataSetKey=aruk-welsh-health-boards&client=alzheimersresearch');    
		    } else if($actual_link=='https://visualisation.polimapper.co.uk/?dataSetKey=aruk-dementia-prevalence') {
		       header('Location:https://visualisation.polimapper.co.uk/?dataSetKey=aruk-dementia-prevalence&client=alzheimersresearch');    
		    } else if($actual_link=='https://visualisation.polimapper.co.uk/?dataSetKey=aruk-scottish-health-boards') {
		       header('Location:https://visualisation.polimapper.co.uk/?dataSetKey=aruk-scottish-health-boards&client=alzheimersresearch');    
		    } else if($actual_link=='https://visualisation.polimapper.co.uk/?dataSetKey=bikeability-local-authority-school-percentage') {
		       header('Location:https://visualisation.polimapper.co.uk/?dataSetKey=bikeability-local-authority-school-percentage&client=bikeability');    
		    } else if($actual_link=='https://visualisation.polimapper.co.uk/?dataSetKey=bikeability-local-authority-2019-2020') {
		       header('Location:https://visualisation.polimapper.co.uk/?dataSetKey=bikeability-local-authority-2019-2020&client=bikeability');    
		    } else if($actual_link=='https://visualisation.polimapper.co.uk/?dataSetKey=bikeability-by-constituency-2019') {
		       header('Location:https://visualisation.polimapper.co.uk/?dataSetKey=bikeability-by-constituency-2019&client=bikeability');    
		    } else if($actual_link=='https://visualisation.polimapper.co.uk/?dataSetKey=bikeabilityinstructors') {
		       header('Location:https://visualisation.polimapper.co.uk/?dataSetKey=bikeabilityinstructors&client=bikeability');    
		    } else if($actual_link=='https://visualisation.polimapper.co.uk/?dataSetKey=evhs-') {
		       header('Location:https://visualisation.polimapper.co.uk/?dataSetKey=evhs-&client=electricalsafetyfirst');    
		    } else if($actual_link=='https://visualisation.polimapper.co.uk/?dataSetKey=dementia-prevalence-and-diagnosis') {
		       header('Location:https://visualisation.polimapper.co.uk/?dataSetKey=dementia-prevalence-and-diagnosis&client=futurehealth');    
		    } else if($actual_link=='https://visualisation.polimapper.co.uk/?dataSetKey=futurehealthwhoopingcough') {
		       header('Location:https://visualisation.polimapper.co.uk/?dataSetKey=futurehealthwhoopingcough&client=futurehealth');    
		    } else if($actual_link=='https://visualisation.polimapper.co.uk/?dataSetKey=futurehealthshingles') {
		       header('Location:https://visualisation.polimapper.co.uk/?dataSetKey=futurehealthshingles&client=futurehealth');    
		    } else if($actual_link=='https://visualisation.polimapper.co.uk/?dataSetKey=futurehealthppv') {
		       header('Location:https://visualisation.polimapper.co.uk/?dataSetKey=futurehealthppv&client=futurehealth');    
		    } else if($actual_link=='https://visualisation.polimapper.co.uk/?dataSetKey=futurehealthcovid') {
		       header('Location:https://visualisation.polimapper.co.uk/?dataSetKey=futurehealthcovid&client=futurehealth');    
		    } else if($actual_link=='https://visualisation.polimapper.co.uk/?dataSetKey=tide-dementia-data') {
		       header('Location:https://visualisation.polimapper.co.uk/?dataSetKey=tide-dementia-data&client=tide');    
		    } else if($actual_link=='https://visualisation.polimapper.co.uk/?dataSetKey=f1c97c7f746904191fd3cc73a1de5f42') {
		       header('Location:https://visualisation.polimapper.co.uk/?dataSetKey=f1c97c7f746904191fd3cc73a1de5f42&client=ukhospitality');    
		    }
		$this->view->show('frontend');
		}
	}

}