<?php if (!defined('THINK_PATH')) exit();?>
宠物列表

<?php if(is_array($petList)): $i = 0; $__LIST__ = $petList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pet): $mod = ($i % 2 );++$i;?><div>
               标题：<?php echo ($pet['subject']); ?>
               种类：<?php echo ($pet['category']); ?>
               品种：<?php echo ($pet['pinzhong']); ?>
               颜色：<?php echo ($pet['color']); ?>
               城市：<?php echo ($pet['city']); ?>
              区域：<?php echo ($pet['area']); ?>
              性别：<?php echo ($pet['sex']); ?> 
              生日：<?php echo ($pet['birthday']); ?> 
    <a href="/index.php/Admin/PetManage/edit?petid=<?php echo ($pet['id']); ?>">编辑</a>
    <a href="/index.php/Admin/PetManage/close?petid=<?php echo ($pet['id']); ?>">关闭</a>
   </div>
   <br/><?php endforeach; endif; else: echo "" ;endif; ?>

<a href="/index.php/Admin/PetManage/newpet">新增宠物</a>