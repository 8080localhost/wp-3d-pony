<?php
$packages = __DIR__.'/packages';

/**
 * 使用scandir 遍历目录
 *
 * @param $path
 * @return array
 */
function getDir($path)
{
    //判断目录是否为空
    if(!file_exists($path)) {
        return [];
    }

    $files = scandir($path);
    $fileItem = [];
    $i = 0;
    foreach($files as $v) {
        $newPath = $path .DIRECTORY_SEPARATOR . $v;
        if(is_dir($newPath) && $v != '.' && $v != '..') {
            $fileItem = array_merge($fileItem, getDir($newPath));
        }else if(is_file($newPath)){
        	$pos = strpos($newPath, 'model.json');
        	if($pos){
        		$newPath = preg_replace('/.+?wp-content/','/wp-content',$newPath);
				$fileItem[$i]['dir'] = $newPath;
				$fileItem[$i]['json'] = $v;
			}
        }
        $i++;
    }
    return $fileItem;
}

$getJson = getDir($packages);
foreach($getJson as $key=>$v){
	$randJson[] = $v['dir'];
}
$randJson = implode(",", $randJson);
$num = count($getJson);

?>
<div class="">
	<h1>WP 3D Pony Settings</h1>
	<form action="" method="post">
		<table>
			<tr><td>开启状态: </td><td>
				<select name="activation">
					<option <?php echo ($this->options['activation'])?'selected="selected"':'' ?> value="1">Active</option>
					<option <?php echo ($this->options['activation'])?'':'selected="selected"' ?> value="0">Disabled</option>
				</select>
			</td></tr>
			<tr><td>随机切换模型: </td><td>
				<select name="rand">
					<option <?php echo ($this->options['rand'])?'selected="selected"':'' ?> value="1">Active</option>
					<option <?php echo ($this->options['rand'])?'':'selected="selected"' ?> value="0">Disabled</option>
				</select>
			</td></tr>
			<input type="hidden" name="randJson" value="<?php echo($randJson);?>" />
			<tr><td>模型Json配置: </td><td>
				<select name="json">
					<?php foreach($getJson as $key=>$v){?>
						<option <?php echo ($this->options['json']==$v['dir'])?'selected="selected"':'' ?> value="<?php echo $v['dir'];?>"><?php echo $v['json'];?></option>
					<?php }?>
				</select>
				*需关闭随机切换模型(总数量:<?php echo($num);?>)
			</td></tr>
			<tr><td>位置: </td><td>
				<select name="position">
					<option <?php echo ($this->options['position']=='right')?'selected="selected"':'' ?> value="right">right</option>
					<option <?php echo ($this->options['position']=='left')?'selected="selected"':'' ?> value="left">left</option>
				</select>
			</td></tr>
			<tr><td>Width: </td><td>
				<input type="text" name="width" id="width" value="<?php echo $this->options['width'] ?>" />px
			</td></tr>
			<tr><td>Height: </td><td>
				<input type="text" name="height" id="height" value="<?php echo $this->options['height'] ?>" />px
			</td></tr>
			<tr><td>横向偏移量: </td><td>
				<input type="text" name="hoffset" id="hoffset" value="<?php echo $this->options['hOffset'] ?>" />px
			</td></tr>
			<tr><td>纵向偏移量: </td><td>
				<input type="text" name="voffset" id="voffset" value="<?php echo $this->options['vOffset'] ?>" />px
			</td></tr>
			<tr><td>PC端模型缩放: </td><td>
				<input type="text" name="scale" id="scale" value="<?php echo $this->options['scale'] ?>" />times
			</td></tr>
			<tr><td>默认不透明度: </td><td>
				<input type="text" name="opacitydefault" id="opacitydefault" value="<?php echo $this->options['opacityDefault'] ?>" />%
			</td></tr>
			<tr><td>鼠标经过不透明度: </td><td>
				<input type="text" name="opacityonhover" id="opacityonhover" value="<?php echo $this->options['opacityOnHover'] ?>" />%
			</td></tr>
			<tr><td>移动端开启状态: </td><td>
				<select name="mobile">
					<option <?php echo ($this->options['mobile'])?'selected="selected"':'' ?> value="1">Active</option>
					<option <?php echo ($this->options['mobile'])?'':'selected="selected"' ?> value="0">Disabled</option>
				</select>
			</td></tr>
			<tr><td>移动端模型缩放: </td><td>
				<input type="text" name="mscale" id="mscale" value="<?php echo $this->options['mscale'] ?>" />times
			</td></tr>
		</table>
		<input type="submit" class="button-primary" value="更改"/><br />
	</form>
	<br /><br /><br />
	Developed by <a href="https://github.com/juzeon/" target="_blank">@juzeon</a>. Details for this plugin: <a href="https://github.com/juzeon/wp-3d-pony" target="_blank">https://github.com/juzeon/wp-3d-pony</a>
</div>