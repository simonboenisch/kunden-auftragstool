<?php
session_start();
if ($_SESSION['loggedIn'] != true) {
    header("Location: ../index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        /* Grundlegende Einstellungen */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header & Navigation */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        nav a {
            margin-left: 15px;
            text-decoration: none;
            color: #0066cc;
        }

        nav a:hover {
            text-decoration: underline;
        }

        /* Überschriften & Text */
        h1,
        h2,
        h3 {
            color: #111;

        }

        /* Abschnitte / Boxen */
        section,
        article {
            background: #ffffff;
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        /* Buttons & Links */
        button,
        input[type="submit"] {
            background-color: #0066cc;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: #004999;
        }

        /* Footer */
        footer {
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 15px;
            margin-top: 40px;
            color: #777;
            font-size: 0.9rem;
        }

        /* --------- */
        .add_form {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .textbox {
            max-width: full;
            resize: none;
            height: 10rem;
        }

        #neuer_auftrag {
            display: none;
        }

        #auftrag_loeschen {
            display: none;
        }

        .auftraege {
            gap: 2rem;
            background-color: white;
            padding: 1rem;
            border-radius: 3px;
            margin-top: 2rem;
            box-shadow: 0px 0px 6px gray;
        }
    </style>
</head>

<body>
    <header>Aufträge verwalten</header>
    <div class="tabs">
        <button onclick="show(1)">Aufträge</button>
        <button onclick="show(2)">Neuer Auftrag</button>
        <button onclick="show(3)">Auftrag Löschen</button>
        <!--<button onclick="show(4)">Aufträge bearbeiten</button>-->
    </div>
    <main>
        <div id="neuer_auftrag">
            <form action="add.php" method="POST" class="add_form">
                <h3>Auftrag Hinzufügen:</h3>

                <label for="title">Auftragstitel:</label>
                <input type="text" name="title">

                <label for="discri">Beschreibung:</label>
                <textarea name="discri" class="textbox"></textarea>

                <label for="title">Auftraggeber:</label>
                <input type="text" name="client">

                <label for="title">E-Mail Auftraggeber:</label>
                <input type="text" name="email">

                <label for="title">Telephon Auftraggeber:</label>
                <input type="text" name="telephone">

                <label for="title">Adresse Auftraggeber:</label>
                <input type="text" name="adress">

                <button type="submit" style="margin-top: 1rem;">Hinzufügen</button>
            </form>
        </div>


        <div id="auftrag_loeschen">
            <form action="delete.php" method="POST" class="add_form">
                <h3>Auftrag Löschen:</h3>
                <label for="id">Auftrags ID:</label>
                <input type="text" name="id" style="margin-bottom: 1rem;">
                <input type="submit">
            </form>
        </div>


        <div id="auftraege" class="auftraege">
            <?php
            $db = new SQLite3('auftraege.db');
            $eintraege = $db->query("SELECT * FROM auftraege");

            while ($row = $eintraege->fetchArray(SQLITE3_ASSOC)) {
                $id = isset($row['auftrags_id']) ? $row['auftrags_id'] : '';
                $titel = isset($row['title']) ? $row['title'] : 'Auftrag';
                $beschreibung = isset($row['beschreibung']) ? $row['beschreibung'] : '';
                $kunde = isset($row['client']) ? $row['client'] : '';
                $email = isset($row['email']) ? $row['email'] : '';
                $telefon = isset($row['telephone']) ? $row['telephone'] : '';
                $adresse = isset($row['adress']) ? $row['adress'] : '';
            ?>

                <div class="auftrag-karte" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 5px;">
                    <details>
                        <summary><b>Details</b></summary>
                        <div style="margin-top: 10px;">
                            <p><b>ID:</b> <?php echo htmlspecialchars($id); ?></p>
                            <p><b>Kunde:</b> <?php echo htmlspecialchars($kunde); ?></p>
                            <p><b>Email Kunde:</b> <?php echo htmlspecialchars($email); ?></p>
                            <p><b>Telephon:</b> <?php echo htmlspecialchars($telefon); ?></p>
                            <p><b>Adresse:</b> <?php echo htmlspecialchars($adresse); ?></p>
                        </div>
                    </details>

                    <div style="margin-top: 10px;">
                        <h3><?php echo htmlspecialchars($titel); ?></h3>
                        <p><?php echo htmlspecialchars($beschreibung); ?></p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

        <div id="bearbeiten" style="margin-top: 2rem;">
            <label for="searching_title">Auftrags ID</label>
            <input type="search" placeholder="" name="searching_title">
            <input type="submit">
        </div>
    </main>
    <script>
        show(1);

        function show(state) {
            const neu = document.getElementById("neuer_auftrag");
            const loeschen = document.getElementById("auftrag_loeschen");
            const auftraege = document.getElementById("auftraege");
            const bearbeiten = document.getElementById("bearbeiten");

            if (state == 1) {
                neu.style.display = 'none';
                loeschen.style.display = 'none';
                auftraege.style.display = 'block';
                bearbeiten.style.display = 'none';
            } else if (state == 2) {
                neu.style.display = 'block';
                loeschen.style.display = 'none';
                auftraege.style.display = 'none';
                bearbeiten.style.display = 'none';
            } else if (state == 3) {
                neu.style.display = 'none';
                loeschen.style.display = 'block';
                auftraege.style.display = 'none';
                bearbeiten.style.display = 'none';
            } else if (state == 4) {
                neu.style.display = 'none';
                loeschen.style.display = 'none';
                auftraege.style.display = 'none';
                bearbeiten.style.display = 'block';
            }
        }
    </script>
</body>

</html>