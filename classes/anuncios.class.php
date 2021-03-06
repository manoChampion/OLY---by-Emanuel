<?php

  Class Anuncios {
    public function getMeusAnuncios() {
      global $pdo;
      $array = array();
      $sql = $pdo->prepare("SELECT *, (select anuncios_imagens.url from anuncios_imagens
			where anuncios_imagens.id_anuncio = anuncios.id
            limit 1) as url from anuncios where id_usuario = :id_usuario");
      $sql->bindValue(":id_usuario", $_SESSION['cLogin']);
      $sql->execute();

      if ($sql->rowCount() > 0) {
        $array = $sql->fetchAll();
      }
      return $array;
    }

    public function addAnuncio($titulo, $categoria, $valor, $descricao, $estado) {
      global $pdo;

      $sql = $pdo->prepare("INSERT INTO anuncios SET titulo = :titulo,
      id_categoria = :id_categoria, id_usuario = :id_usuario, valor = :valor,
      descricao = :descricao, estado = :estado");

      $sql->bindValue(":titulo", $titulo);
      $sql->bindValue(":id_categoria", $categoria);
      $sql->bindValue(":id_usuario", $_SESSION['cLogin']);
      $sql->bindValue(":valor", $valor);
      $sql->bindValue(":descricao", $descricao);
      $sql->bindValue(":estado", $estado);
      $sql->execute();
    }

    public function numeroAnuncios() {
      global $pdo;

      $sql = $pdo->query("SELECT * FROM anuncios");
      $sql = $sql->rowCount();

      if ($sql <= 0) {
       echo "ZERO";
     } else {
       echo $sql;
     }
    }

    public function excluirAnuncio($id) {
      global $pdo;

      $sql = $pdo->prepare("DELETE FROM anuncios_imagens WHERE id_anuncio = :id_anuncio");
      $sql->bindValue(":id_anuncio", $id);
      $sql->execute();

      $sql = $pdo->prepare("DELETE FROM anuncios WHERE id = :id");
      $sql->bindValue(":id", $id);
      $sql->execute();
    }

    public function getAnuncio($id) {
      $array = array();
      global $pdo;

      $sql = $pdo->prepare("SELECT * FROM anuncios WHERE id = :id");
      $sql->bindValue(":id", $id);
      $sql->execute();

      if ($sql->rowCount() > 0) {
        $array = $sql->fetch();
      }
      return $array;
    }
  }

 ?>
