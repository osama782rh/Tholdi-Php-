<?php 
    session_start();
    require('fpdf/fpdf.php');
    require_once 'config.php';
    
    $codeUtilisateur = $_SESSION['codeUtilisateur'];

    $bdd = gestionnaireDeConnexion();
    // On récupere les données de l'utilisateur
    $collectionInfos = afficherInfoUtilisateur($codeUtilisateur);
    $collectionInfosReservation = listeRerservation();
    
    
 
class PDF extends FPDF {

// En-tête
        function Header() {
            // Logo
            $this->Image('images/logo.png', 10, 6, 24);
            // Police Arial gras 15
            $this->SetFont('Arial', 'B', 15);
            // Décalage à droite
            $this->Cell(80);
            // Titre
            $this->Cell(30, 10, 'Devis', 1, 0, 'C');
            // Saut de ligne
            $this->Ln(20);
        }

// Pied de page
        function Footer() {
            // Positionnement à 1,5 cm du bas
            $this->SetY(15);
            // Police Arial italique 8
            $this->SetFont('Arial', 'I', 8);
            // Numéro de page
            $this->Cell(0, 10, 'Page ' . $this->PageNo() . '', 0, 0, 'C');
        }

    }

// Instanciation de la classe dérivée
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);

    $pdf->Cell(1, 10, 'THOLDI ', 0, 0);

    $pdf->Cell(1, 19, '48 Boulevard Haussmann ', 0, 0);

    $pdf->Cell(1, 29, '75006 PARIS ', 0, 0);

    $pdf->Cell(1, 39, 'https://www.tholdi.com', 0, 0);

    foreach($collectionUtilisateur as $dataU)
{
    $pdf->Cell(98, 20, '', 0, 0);
    $pdf->Cell(300, 15, $dataU["raisonSociale"], 0, 1);


    $pdf->Cell(100, 6, '', 0, 0);
    $pdf->Cell(300, 6, $dataU["adresse"], 0, 1);

    $pdf->Cell(100, 6, '', 0, 0);
    $pdf->Cell(300, 6, $dataU["cp"], 0, 1);

    $pdf->Cell(100, 6, '', 0, 0);
    $pdf->Cell(300, 6, $dataU["ville"], 0, 1);

    $pdf->Cell(100, 6, '', 0, 0);
    $pdf->Cell(300, 6, $dataU["adrMel"], 0, 1);

    $pdf->Cell(100, 6, '', 0, 0);
    $pdf->Cell(300, 6, $dataU["telephone"], 0, 1);

    $pdf->Cell(100, 6, '', 0, 0);
    $pdf->Cell(300, 6, $dataU["contact"], 0, 1);
}

foreach($collectionInfosReservation as $infos)


    $pdf->Cell(30, 8, 'Date debut resérvation : ', 0, 0);
    $pdf->Cell(85, 8, $codeReservation, 0, 1); //end of line

    $pdf->Cell(18, 8, 'Date fin resérvation : ', 0, 0);
    $pdf->Cell(85, 8, $dateDebutReservation, 0, 1); //end of line

    $pdf->Cell(39, 8, 'Volume estimé : ', 0, 0);
    $pdf->Cell(85, 8, $codeUtilisateur, 0, 1); //end of line





//make a dummy empty cell as a vertical spacer
$pdf->Cell(189, 10, '', 0, 1); //end of line
//invoice contents
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(17, 5, 'Volume', 1, 0);
$pdf->Cell(30, 5, 'Quantite', 1, 0);
$pdf->Cell(83, 5, 'Description', 1, 0);
$pdf->Cell(30, 5, 'Prix unitaire', 1, 0);
$pdf->Cell(34, 5, 'Tarif', 1, 1); //end of line

$pdf->SetFont('Arial', '', 12);

//Numbers are right-aligned so we give 'R' after new line parameter
$prixContainer = null;
$total = null;
foreach ($collectionInfos as $infos)
{
    $prixContainer = $infos['tarif'] * $infos['nbJourReserse'] * $infos['qteReserver'];
    $total += $prixContainer;
    $pdf->Cell(17, 5, $infos["volumeEstime"], 1, 0);
    $pdf->Cell(30, 5, $infos["qteReserver"], 1, 0);
    $pdf->Cell(83, 5, $infos["libelleTypeContainer"], 1, 0);
    $pdf->Cell(30, 5, $infos["tarif"], 1, 0);
    $pdf->Cell(34, 5, $prixContainer, 1, 1, 'R'); //end of line
}
    $total;
    //summary

    //$total = $_SESSION['total'];
    $pdf->Cell(135, 1, '', 0, 0);
    $pdf->Cell(29, 9, 'Montant : ', 0, 0);
    $pdf->Cell(30, 9, $total . ' euros', 1, 1, 'R'); //end of line

    $pdf->Output("devis Tholdi Commande " . $codeReservation . ".pdf",'D');
    
    //$pdf->Output();
