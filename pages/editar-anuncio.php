<?php require 'header.php'; ?>
<?php
  if (empty($_SESSION['cLogin'])) {
    ?>
    <script type="text/javascript">window.location.href="../index.php";</script>
    <?php
    exit;
  }
 ?>
<?php require '../classes/categorias.class.php'; ?>
<?php
  require '../classes/anuncios.class.php';

  $a =  new Anuncios();
  if (isset($_POST['titulo']) && !empty($_POST['titulo'])) {
    $titulo = addslashes($_POST['titulo']);
    $categoria = addslashes($_POST['categoria']);
    $valor = addslashes($_POST['valor']);
    $descricao = addslashes($_POST['descricao']);
    $estado = addslashes($_POST['estado']);

    $a->addAnuncio($titulo, $categoria, $valor, $descricao, $estado);
    ?>
      <div class="alert alert-success">
        Seu produto está no ar!!!
      </div>
    <?php
  }

  if (isset($_GET['id']) && !empty($_GET['id'])) {
    $info = $a->getAnuncio($_GET['id']);
  } else { ?>
    <script type="text/javascript">window.location.href="meus-anuncios.php"</script>
  <?php }
?>

 <div class="container">
   <h1>Meus Anúncios - Adicionar Anúncio</h1>

   <form method="post" enctype="multipart/form-data">
     <div class="form-group">
       <label for="categoria">Categorias:</label>
       <select name="categoria" class="form-control" required>
         <?php
          $c =  new Categorias();
          $cats = $c->getLista();
          foreach ($cats as $cat):
            ?>
            <option value="<?php echo $cat['id']; ?>" <?php echo ($info['id_categoria']==$cat['id'])?'selected="selected"':''; ?>><?php echo utf8_encode($cat['nome']); ?></option>
            <?php
          endforeach;
          ?>
       </select>
     </div>
     <div class="form-group">
       <label for="titulo">Título:</label>
       <input type="text" name="titulo" value="<?php echo $info['titulo']; ?>" class="form-control" required>
     </div>
     <div class="form-group">
       <label for="valor">Valor:</label>
       <input type="text" name="valor" class="form-control" value="<?php echo $info['valor']; ?>" required>
     </div>
     <div class="form-group">
       <label for="descricao">Descrição:</label>
       <textarea name="descricao" class="form-control" value=""><?php echo $info['descricao']; ?></textarea>
     </div>
     <div class="form-group">
      <label for="estado">Estado de Conservação:</label>
      <select class="form-control" name="estado" required>
          <option value="0" <?php echo ($info['estado']=='0')?'selected="selected"':''; ?>>Ruim</option>
          <option value="1" <?php echo ($info['estado']=='1')?'selected="selected"':''; ?>>Bom</option>
          <option value="2" <?php echo ($info['estado']=='2')?'selected="selected"':''; ?>>Ótimo</option>
      </select>
     </div>
     <button type="submit" name="button" class="btn btn-primary">Salvar</button>
   </form>
 </div>

 <?php require 'footer.php'; ?>
