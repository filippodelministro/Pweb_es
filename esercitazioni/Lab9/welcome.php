<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Welcome</title>
	</head>
	<body>
        
        <?php
            session_start();
            if(isset($_POST['destroy'])) {
                session_destroy();
                header("Location:welcome.php");
            }


            if (!empty($_POST["nome"])){
                $_SESSION['nome'] = $_POST["nome"];
            }
            if (!empty($_POST["cognome"])){
                $_SESSION["cognome"] = $_POST["cognome"];
            }


            if (empty($_SESSION['nome']) ||empty($_SESSION['cognome'])) {
                header('Location:register.html');
                exit();
            } else {
                echo "Benvenuto ".$_SESSION['nome']." ".$_SESSION['cognome'];
            }
        ?>
        <form method="post">
            <input type="submit" name="destroy" value="Destroy session"/>
        </form>
        
    </body>
</html>