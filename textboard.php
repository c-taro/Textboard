<html>
<head>
<title>�v���O���~���O�u���O</title>
</head>
<body>
<h1>�v���O���~���O�u���O</h1>

<?php
//�ҏW�˗����ꂽ��
if ($_POST['edit1']){

	//�㏑�����ꂽ�e�L�X�g�t�@�C�����Ăяo��
	$filename3 = 'file.txt';
	$file3 = file($filename3);

	//�폜���������e�̃p�X���[�h�icolumn3[4]�j���擾
	foreach($file3 as $array3){
		$column3 = explode("<>",$array3);

		if($column3[0] == $_POST['edit1']){
			break;
		}
	}

	//�m�F�p�p�X���[�h���ҏW���������e�̃p�X���[�h�icolumn3[4]�j�ƈ�v�����ꍇ
	if(trim($_POST['edit_password1']) === trim($column3[4])){
		$edittext3 = $column3;

		$edit_mode3 = 1;//���̓t�H�[����ҏW���[�h�ɂ���
		$edit_num3 = $_POST['edit1'];//�ҏW���������e�̓��e�ԍ�

	}else{
		$error = 1;//�t�H�[���̉��Ɂu!!�p�X���[�h����v���܂���!!�v�ƕ\�������邽�߂̏���
	}
}
?>

<!--���̓t�H�[��-->
<form method="post" action="textboard.php">
	
	���L���u<>�v�͎g�p���Ȃ��ł��������B<br/><br/>
	���O�F<br/>
        <input type="name" name="name0" value="<?= $edittext3[1] ?>"><br/>
	�R�����g�F<br/>
        <textarea cols="40" rows="10" name="comment0"><?= $edittext3[2] ?></textarea><br/>
	�p�X���[�h�F<br/>
	<input type="name" name="password0" value="<?= $edittext3[4] ?>"><br/><br/>
	<input type="submit" name="send0" value="���M"><br/><br/><br/>

	<input type="submit" name="delete0" value="���e���폜"><br/><br/>
	<input type="submit" name="edit0" value="���e��ҏW">

	<input type="hidden" name="edit_mode0" value="<?= $edit_mode3 ?>">
	<input type="hidden" name="edit_num0" value="<?= $edit_num3 ?>">

</form>


<?php

if ($_POST['edit_mode0'] != 1){
	//���O�ƃR�����g���������܂ꂽ�ꍇ�́A�e�L�X�g�t�@�C���ɏ������ޏ��� �V�K���e
	if ($_POST['name0'] && $_POST['comment0'] && $_POST['password0'] && $_POST['send0']){

		//�e�L�X�g�t�@�C�����Ăяo��
		$filename1 = 'file.txt';
		$fp1 = fopen($filename1, 'a');

		//���e�ԍ��̐ݒ�
		$file1 = file($filename1);
		$turn1 = count($file1);

		//���O�̐ݒ�
		$name1 = $_POST['name0'];

		//�R�����g�̐ݒ�
		$comment1 = $_POST['comment0'];

		//���e���Ԃ̐ݒ�
		$time1 = date("Y/m/d H:i:s");

		//�p�X���[�h�̐ݒ�
		$password1 = $_POST['password0'];

		//�\���`���̐ݒ�
		$column1 = array($turn1+1, $name1, $comment1, $time1, $password1);

		//�e�L�X�g�t�@�C���ɏ�������
		fwrite($fp1, $column1[0]."<>".$column1[1]."<>".$column1[2]."<>".$column1[3]."<>".$column1[4]."<>\n");

		fclose($fp1);

	}elseif($_POST['delete0']){
?>
		<!--���̓t�H�[��-->
		<form method="post" action="textboard.php">
		�폜���������e�̓��e�ԍ��F<br/>
		<input type="name" name="delete1"><br/>
		�폜���������e�̃p�X���[�h�F<br/>
		<input type="name" name="delete_password1"><br/><br/>
		<input type="submit" value="���M"><br/>
		</form>
<?php
	
	}elseif($_POST['edit0']){
?>
		<!--���̓t�H�[��-->
		<form method="post" action="textboard.php">
		�ҏW���������e�̓��e�ԍ��F<br/>
		<input type="name" name="edit1"><br/>
		�ҏW���������e�̃p�X���[�h�F<br/>
		<input type="name" name="edit_password1"><br/><br/>
		<input type="submit" value="���M"><br/>
		</form>
<?php
	}
}



//�폜�˗����ꂽ��
if ($_POST['delete1'] && $_POST['delete_password1']){

	//�㏑�����ꂽ�e�L�X�g�t�@�C�����Ăяo��
	$filename2 = 'file.txt';
	$file2 = file($filename2);

	//�폜���������e�̃p�X���[�h�ipre_column2[4]�j���擾
	foreach($file2 as $pre_array2){
		$pre_column2 = explode("<>",$pre_array2);
		if($pre_column2[0] == $_POST['delete1']){
			$check2 = $pre_column2[4];
		}
	}

	//�m�F�p�p�X���[�h���폜���������e�̃p�X���[�h�ƈ�v�����ꍇ
	if(trim($_POST['delete_password1']) === trim($check2)){
		//�폜�w�肳�ꂽ���e���������ăt�@�C�����ĕۑ�
		$fp2 = fopen($filename2, 'w');
		$turn2=1;//���e�ԍ�
		foreach($file2 as $key2 => $array2){
			$column2 = explode("<>", $array2);
			if ($_POST['delete1']-1 != $key2){
				fwrite($fp2, $turn2."<>".$column2[1]."<>".$column2[2]."<>".$column2[3]."<>".$column2[4]."<>\n");
				$turn2++;
			}
		}
		fclose($fp2);
	}else{
		$error = 1;
	}
}


//�폜�ƕҏW�Ńp�X���[�h����v���Ȃ��ꍇ�̏���
if($error == 1){
	echo "!!�p�X���[�h����v���܂���!!"."<br/><br/><br/>";
	$error = 0;
}


//�ҏW�������e���t�@�C���ɏ㏑��
if($_POST['edit_mode0'] == 1){

	//�㏑�����ꂽ�e�L�X�g�t�@�C�����Ăяo��
	$filename5 = 'file.txt';
	$file5 = file($filename5);
	$fp5 = fopen($filename5, 'w');

	//���O�̐ݒ�
	$name5 = $_POST['name0'];

	//�R�����g�̐ݒ�
	$comment5 = $_POST['comment0'];

	//���e���Ԃ̐ݒ�
	$time5 = date("Y/m/d H:i:s");

	//�p�X���[�h�̐ݒ�
	$password5 = $_POST['password0'];

	//�ҏW�w�肳�ꂽ���e�������������ăt�@�C�����ĕۑ�
	foreach($file5 as $array5){
		$column5 = explode("<>", $array5);

		if ($_POST['edit_num0'] != $column5[0]){//�Ăяo�������e�ԍ����ҏW�ԍ��ƈႤ�ꍇ
			fwrite($fp5, $column5[0]."<>".$column5[1]."<>".$column5[2]."<>".$column5[3]."<>".$column5[4]."<>\n");//�����̓��e���t�@�C���ɓ����
		}else{//�Ăяo�������e�ԍ����ҏW�ԍ��Ɠ����ꍇ
			fwrite($fp5, $column5[0]."<>".$name5."<>".$comment5."<>".$time5."<>".$password5."<>\n");//�ҏW�������e���t�@�C���ɓ����
		}
	}
	fclose($fp5);
	$edit_mode3 = 0;//���̓t�H�[����V�K���e���[�h�ɒ���
}


//�f���̕\��
//�㏑�����ꂽ�e�L�X�g�t�@�C�����Ăяo��
$filename4 = 'file.txt';
$fp4 = fopen($filename4, 'a');
$file4 = file($filename4);

//�f���̕\��
foreach($file4 as $array4){
	$column4 = explode("<>" ,$array4);
	echo $column4[0]."�F".$column4[1]."<br/>".$column4[2]."<br/>".$column4[3]."<br/><br/>";
}

fclose($fp4);
?>
</body>
</html>