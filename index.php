<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Projeto Comentários</title>
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
        <?php
        try {
            $pdo = new PDO("mysql:dbname=projeto_comentarios;host=localhost", "root", "");
        } catch (PDOException $e) {
            echo "ERRO: ".$e->getMessage();
            exit;
        }
        
        If(isset($_POST['nome']) && !empty($_POST['nome'])){
            $nome = $_POST['nome'];
            $msg = $_POST['msg'];
            
            $sql = $pdo->prepare("INSERT INTO mensagens (nome, msg, data_msg) VALUES (:nome, :msg, NOW())");
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":msg", $msg);
            $sql->execute();
        }
        ?>
        <fieldset>
            <form method="POST">
                Nome:<br>
                <input type="text" name="nome"><br/><br/>
                
                Mensagem:<br/>
                <textarea name="msg"></textarea><br><br>
                
                <input type="submit" value="Enviar Mensagem">
            </form>
        </fieldset>
        <br><br>
        
        <?php
        $sql = "SELECT * FROM mensagens ORDER BY data_msg DESC";
        $sql = $pdo->query($sql);
        if ($sql->rowCount() > 0){
            foreach ($sql->fetchAll() as $msg):
                ?>
        <strong><?php echo $msg['nome']; ?></strong><?php echo " ".$msg['data_msg']; ?><br>
                <?php echo $msg['msg']; ?>
                <hr>
                <?php
            endforeach;
        }else {
            echo "Não há mensagens.";
        }
        ?>
    </body>
</html>
