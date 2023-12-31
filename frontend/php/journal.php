<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="rr margin-bottom">
                <h1 class="mt-4">Mon journal</h1>
                <button class="side-btn" id="ajouterJournalBtn">Ajouter <i class="fas fa-plus-circle"></i></button>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i> Mon historique de consommation
                </div>
                <div class="card-body">
                    <table id="journalDataTable"  class="hover  order-column row-border ">
                        <thead>
                        <tr>
                            <th>Aliments/Plats consommé</th>
                            <th>Date de consommation</th>
                            <th>Quantité</th>
                            <th>Valeurs nutritionnelles du plat</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
    </main>
    <?php
    //session_start(); // Démarrez la session si ce n'est pas déjà fait

    // Récupérez la valeur de $_SESSION['user']
    $user = $_SESSION['user'];
    ?>

    <script>
        var id_user = <?php echo json_encode($user); ?>;
        const prefixeEndpoint = <?php echo json_encode(prefixeEndpoint); ?>;
    </script>
    <script type="text/javascript" src="../js/journal.js"></script>


