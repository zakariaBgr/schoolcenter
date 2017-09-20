 <?php
	if( isset($_POST['connexion']) ) {
		$login = $_POST['inputEmail'];
	}
 ?>

 <form method="post" name="form_upload" role="form" action="upload.php" enctype="multipart/form-data">
 	 <div class="form-group">
        <label for="Sujet">Nom du sujet </label>
        <input type="text" name="Sujetname" class="form-control" id="Sujet" placeholder="Nom du sujet" >
        <input type="hidden" name="inputEmail" value="<?php echo $login; ?>"
    </div>
    <div class="form-group">
        <label for="exampleInputFile">Upload</label>
        <input type="file" name="fichier" size="30">
        <p class="help-block">Télécharger le sujet en format image ( jpg, png...)</p>
    </div>
 <button type="submit" name="upload" class="btn btn-primary"><i class="icon icon-check icon-lg"></i> Valider</button>
   <form>