<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;


include_once DOC_ROOT . '/Application/Common/service/HtmlRenderService.class.php';
include_once DOC_ROOT . '/Application/Common/service/SmsService.class.php';

class AttributeController extends Controller {
	
	public  function getCityList() {
	    $Dao = M ( "city" );
		$cityList = $Dao->group('city')->select();
		return $this->ajaxReturn ( \HtmlRenderService::successJson($cityList), "JSONP" ); 
	}
	
	public  function getAreaList() {
		$city = $_GET ["city"];
		if(empty($city)){
			$this->ajaxReturn ( \HtmlRenderService::errorJson("city empty"), "JSONP" );
		}
		
		$condition ['city'] = $city;
		
		$Dao = M ( "city" );
		$areaList = $Dao->where ($condition) ->order("'order'")->select();
		
		//echo  $Dao->getLastSql();
		return $this->ajaxReturn ( \HtmlRenderService::successJson($areaList), "JSONP" );
	}
	
	public  function getPinzhongList() {
		$category = $_GET ["category"];
		if(empty($category)){
			$this->ajaxReturn ( \HtmlRenderService::errorJson("category empty"), "JSONP" );
		}
	
		$condition ['category'] = $category;
	
		$Dao = M ( "category" );
		$pinzhongList = $Dao->where ($condition) ->order("'order'")->select();
	
		//echo  $Dao->getLastSql();
		return $this->ajaxReturn ( \HtmlRenderService::successJson($pinzhongList), "JSONP" );
	}
	
}