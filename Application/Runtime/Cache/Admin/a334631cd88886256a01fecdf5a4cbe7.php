<?php if (!defined('THINK_PATH')) exit();?>
新建宠物

<form action="/index.php/Admin/PetManage/create" method="post">
  <p>标题：<input type="text" name="subject" value=""/></p>
  <p>种类：
    <select name='category'>
	  <option value ="cat">喵星人</option>
	  <option value ="dog">汪星人</option>
	</select>
  </p>
  
  <p>品种：
    <select name='pinzhong' data-pz="{'cat':['英短','美短'],'dog':['金毛','国美']}">
	  <option value ="英短">英短</option>
	</select>
  </p>
  <p>颜色：
    <select name='color'>
	  <option value ="白色">白色</option>
	  <option value ="黑色">黑色</option>
	  <option value ="棕色">棕色</option>
	</select>
  </p>


  <p>城市：
    <select  name='city'>
	  <option value ="杭州">杭州</option>
	</select>
  </p>
  <p>县/区：
    <select name='area'>
      <option value ="上城区">上城区</option>
      <option value ="下城区">下城区</option>
      <option value ="拱墅区">拱墅区</option>
      <option value ="江干区">江干区</option>
      <option value ="西湖区">西湖区</option>
	  <option value ="滨江区">滨江区</option>
	  <option value ="余杭区">余杭区</option>
	  <option value ="萧山区">萧山区</option>
	</select>
  </p>
  <p>详细地址 ：<input type="text" name="address" value="" placeholder="例如：钱龙大厦1单元513室"/></p>
  
  <p>照片：<input type="text" name="img" placeholder="照片url" /></p>
  <p>性别：
    <select name='sex'>
	  <option value ="M">公</option>
	  <option value ="F">母</option>
	</select>
  </p>
  <p>生日：<input type="text" name="birthday" /></p>

  <input type="submit" value="Submit" />
</form>