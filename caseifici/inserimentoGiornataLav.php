
<?php 
    include "connection.php"; 
    session_start(); 

    if(!isset($_SESSION['codiceCaseificio'])){
        header("Location: index.php");
        exit();
    }

    function getCurrentDay() {
        $currentDate = new DateTime();
        return $currentDate->format('d/m/Y');
    }
?>

<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Consorizio Caseifici</title>
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #453F78;
            
        }

        .header {
            background-color: #795458;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            margin: 0;
            color: #FFC94A;
        }

        

        .buttons {
            display: flex;
            align-items: center;
        }

        .button-containers {
            display: flex;
            justify-content: space-between;
            padding: 10px;
        }

        .button {
            background-color: #FFC94A;
            border: none;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
            margin-left: 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 10px; /* Make the buttons rounded */
            text-decoration: none;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px;
            background-color: #FFFEEF;
            border: 2px solid #FFC94A;
            border-radius: 10px;
            margin:20px;

        }

        .date-input{
            size: 16px; 
            border-radius: 10px;
        }

        .date-input-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #795458;
            margin-bottom: 20px;
            border: 2px solid #FFC94A;
            border-radius: 10px;
            color:#FFC94A;
            margin:20px; 
        }

        

        #filter-form {
            width: 100%;
            margin:20px; 
            color:#FFC94A;
            border: 2px solid #FFC94A;
            background-color: #795458;
            border-radius: 10px;
            padding: 10px;
        }

        #filter-form button {
            width: 100%; 
            background-color: #FFC94A;
            border: none;
            padding: 10px;
            color: #333;
            font-size: 16px;
            cursor: pointer;
            border-radius: 10px; 
        }

        #filter-form input[type="number"]{
            width: 20%;
            border-radius: 10px;
            border: none;
            font-size: 16px;
            height: auto;
            width: auto;
          
        }
           
        

        #filter-form span {
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
        }

        .bottoneInvioDate{
            background-color: #FFC94A;
            border: none;
            padding: 10px;
            color: #333;
            text-decoration: none;
            margin-left: 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 10px; 
            text-decoration: none;
            
        }

        .errore{
            width: 98%; 
            background-color: #FFFEEF;
            border: none;
            padding: 10px;
            color: #333;
            font-size: 16px;
            text-align: center;
            border-radius: 10px; 
            display: none;
        }
        
        .bottone-disabilitato {
            background-color: #ccc;
            color: #666;
            cursor: not-allowed;
        }
        
    </style>
    <script>
        // Get the input element
        //document.addEventListener("DOMContentLoaded", function () {
            // Get the input element
            //const dateInput = document.getElementById("date-input");

            // Set the value to the current date
            //dateInput.value = new Date().toISOString().slice(0, 10);
        //});

        // Crea una funzione che gestisca l'evento onchange
        function handleQuantitaChange(){
            const quantitaTotale= document.getElementById("gioLav_quanPro").value;
            const quantita12 = document.getElementById("quantita12").value;
            const quantita24 = document.getElementById("quantita24").value;
            const quantita30 = document.getElementById("quantita30").value;
            const quantita36 = document.getElementById("quantita36").value;
            const somma = +quantita12 + +quantita24 + +quantita30 + +quantita36;

            if(quantitaTotale==somma){
                console.log("ABILITATO")
                document.getElementById("bottoneInvio").disabled = false;
                document.getElementById("bottoneInvio").classList.remove("bottone-disabilitato");
            }else{
                console.log("DISABILITATO")
                document.getElementById("bottoneInvio").disabled = true;
                document.getElementById("invio").classList.add("bottone-disabilitato");
            }

            console.log("La somma è:", somma," ",quantitaTotale);
        }

        
    </script>
        
</head>





<body>
    <div class="header">
        <h1>Consorizio Caseifici</h1>
        
        <div class="button-containers">
        <?php 
                if(isset($_SESSION['codiceCaseificio'])){
                    
                    echo'<a class="button" href="menuparteRiservata.php">Parte Riservata</a>';
                }
                
            ?>
            <a class="button" href="login.php">Login</a>
        </div>
    </div>
    
    <div class="container">

        <div class="date-input-container">
            <h2>Giornata:</h2>
            <form action="inserimentoGiornataLav.php" method="get">
                <input type="date" id="dataOggi" value="<?php echo isset($_GET['dataOggi']) ? htmlspecialchars($_GET['dataOggi'])  : ''; 
                                                                isset($_GET['dataOggi']) ? $dataAt= $_GET['dataOggi'] : '';
                                                        ?>">
                <button type="submit" class="bottoneInvioDate">Applica</button>
            </form>
        </div>

        <?php 
            
            $sql='SELECT * FROM giornatelav WHERE gioLav_cas_Id='.$_SESSION[ "codiceCaseificio"].' AND gioLav_date = '.$dataAt;
            $resul=$conn->query($sql);
            if (empty($resul) || $resul->num_rows == 0) {
                // Query result is empty or null
                echo "No data found.";
                echo $_SESSION[ "codiceCaseificio"].' ';
                
            }else{
                $row=$resul->fetch_assoc();

            }
            
        
        ?>
        
       
        <form id="filter-form">
        <h2>Inserimento dati:</h2>
            <span>
              <label for="filter-input-1">Quantità di latte:
              <input  min="0" type="number" id="gioLav_latteLavo" placeholder="Quantità di latte"></label>
            </span>  
            
            <span>
              <label for="filter-input-2">Latte per formaggio:
              <input min="0" type="number" id="gioLav_latteFormag" placeholder="Latte per formaggio"></label>
            </span> 

            <span>
              <label for="filter-input-3">Forme prodotte:
              <input min="0" type="number" id="gioLav_quanPro" onchange="handleQuantitaChange(event)" placeholder="Forme prodotte"></label>
            </span>

            <h3>Informazioni sulle forme</h3>
 
            <span>
                <label>12 Mesi:</label>
                <input min="0" type="number" id="quantita12" onchange="handleQuantitaChange(event)" placeholder="Forme prodotte 12 mesi">
            </span>
            <span>
                <label>24 Mesi:</label>
                <input min="0" type="number" id="quantita24" onchange="handleQuantitaChange(event)" placeholder="Forme prodotte">
            </span>
            <span>
                <label>30 Mesi:</label>
                <input min="0" type="number" id="quantita30" onchange="handleQuantitaChange(event)" placeholder="Forme prodotte">
            </span>
            <span>
                <label>36 Mesi:</label>
                <input min="0" type="number" id="quantita36" onchange="handleQuantitaChange(event)" placeholder="Forme prodotte">
            </span>

            <span>
                <button type="submit" id="bottoneInvio">Invia</button>
            </span>

            <p class="errore">
                Errore di....
            </p>
          </form>
        
        
    </div>

</body>
</html>