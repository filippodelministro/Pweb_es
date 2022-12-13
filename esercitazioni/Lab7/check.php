<?php
    // La funzione empty() restituisce false se la variabile esiste e 
    // non è vuota, altrimenti restituisce true
    if (empty($_GET["username"])){
        echo ("<script>alert('Errore: il nome utente non può essere vuoto'); 
                       window.history.back();
               </script>");
        exit();
    }
    // Una password costituita dal solo carattere 0 non è considerata valida
    if (empty($_GET["password"])){
        echo ("<script>alert('Errore: la password non può essere vuota'); 
                       window.history.back();
               </script>");
        exit();
    }

	// Connessione al database
    // Le impostazioni predefinite di XAMPP prevedono un utente root privo di password
    // Il database users ha può essere creato usando lo script sql fornito con la soluzione
    /*
    MariaDB [users]> show tables;
    +-----------------+
    | Tables_in_users |
    +-----------------+
    | login           |
    +-----------------+
    1 row in set (0,001 sec)

    MariaDB [users]> describe login;
    +----------+-------------+------+-----+---------+-------+
    | Field    | Type        | Null | Key | Default | Extra |
    +----------+-------------+------+-----+---------+-------+
    | usr_name | varchar(45) | NO   | PRI | NULL    |       |
    | hash     | varchar(60) | NO   |     | NULL    |       |
    +----------+-------------+------+-----+---------+-------+
    2 rows in set (0,010 sec)
    */
	$db_connection = mysqli_connect('localhost', 'root', '', 'users');
	if ( mysqli_connect_errno() ) {
		exit('Connessione a database non riuscita. (' . mysqli_connect_error() . ')');
	}

    // Questo script php viene eseguito sia per la registrazione che per il login
    // La registrazione prevede la presenza di un parametro register nella query string
    if (isset($_GET["register"])){
        //Dobbiamo registrare l'utente nel sistema

        // Generiamo l'hash a partire dalla password inserita dall'utente
        $hash =  password_hash($_GET["password"], PASSWORD_BCRYPT);
        // Stringa che definisce lo statememt sql 
		$sql = "INSERT INTO users.login (usr_name, hash) VALUES (?,?)";
        // Preparazione dello statement
		$statement = mysqli_prepare($db_connection, $sql);
        // Binding dei parametri, sono due stringhe quindi ss per specificarne il tipo
        mysqli_stmt_bind_param($statement, "ss", $_GET["username"], $hash);
        // Esecuzione dello statement
        // Restituisce false in caso di errore
        if (!mysqli_stmt_execute($statement)){
            //La query è fallita -> l'utente esiste già
            echo ("<script>alert('Errore: utente già registrato'); 
                           window.history.back(); 
                   </script>");
            exit();
        }else{
            echo ("<script>alert('Utente registrato con successo'); 
                           window.history.back();
                   </script>");
            exit();
        }
        
    } else {
        // Si tratta di una operazione di login
        // Definizione della query sql
        $query = "SELECT hash FROM users.login WHERE usr_name = ?";
        // Preparazione dello statement
        $statement = mysqli_prepare($db_connection, $query);
        // Binding dei paramtri, uno solo di tipo stringa
        mysqli_stmt_bind_param($statement, "s", $_GET["username"]);
        // Esecuzione dello statement
        mysqli_stmt_execute($statement);
    
        // Accesso ai risultati, la variabile $hash verrà riempita con il contenuto
        // della colonna omonima una riga alla volta
        mysqli_stmt_bind_result($statement, $hash);
        // Prelevo una nuova riga dei risultati
        while (mysqli_stmt_fetch($statement)){
            // Se l'hash nella tabella corrisponde con quello calcolato a partire 
            // dalla password che l'utente ha inserito nel form allora il login ha successo
            // La verifica deve essere fatta con la funzione password_verify()
            if (password_verify($_GET["password"], $hash)) {
                echo ("<script>alert('Login avvenuto con successo'); 
                            window.history.back();
                       </script>");
                exit();
            } 
        }
        echo ("<script>alert('Login fallito'); 
                            window.history.back();
               </script>");

    }
?>