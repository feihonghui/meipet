<?php if (!defined('THINK_PATH')) exit();?>

<form action="/index.php/Admin/PetManage/update" method="post">
  <input type="hidden" name="id" value="<?php echo ($pet['id']); ?>">
  <p>标题：<input type="text" name="subject" value="<?php echo ($pet['subject']); ?>"/></p>
  <p>种类：
    <select name='category'>
      <?php if($pet['category'] == 'cat' ): ?><option value ="cat">喵星人</option>
         <option value ="dog">汪星人</option>
	  <?php else: ?>
         <option value ="dog">汪星人</option>
         <option value ="cat">喵星人</option><?php endif; ?>
	</select>
  </p>
  
  <p>品种：
    <select name='pinzhong' data-pz="{'cat':['英短','美短'],'dog':['金毛','国美']}">
	  <option value ="<?php echo ($pet['pinzhong']); ?>"><?php echo ($pet['pinzhong']); ?></option>
	</select>
  </p>
  <p>颜色：
    <select name='color'>
      <option value ="<?php echo ($pet['color']); ?>" ><?php echo ($pet['color']); ?></option>
	  <option value ="白色" >白色</option>
	  <option value ="黑色" >黑色</option>
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
      <option value ="<?php echo ($pet['area']); ?>"><?php echo ($pet['area']); ?></option>
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
  <p>详细地址 ：<input type="text" name="address" value="" placeholder="例如：钱龙大厦1单元513室"/><?php echo ($pet['address']); ?></p>
  
  <p>照片：<input type="text" name="img" placeholder="照片url" /><?php echo ($pet['img']); ?></p>
  <p>性别：
    <select name='sex'>
      <?php if($pet['sex'] == 'M' ): ?><option value ="M">公</option>
	     <option value ="F">母</option>
	  <?php else: ?>
	     <option value ="F">母</option>
         <option value ="M">公</option><?php endif; ?>
	</select>
  </p>
  <p>生日：<input type="text" name="birthday" value="<?php echo ($pet['birthday']); ?>"/></p>

  <input type="submit" value="提交" />
</form>