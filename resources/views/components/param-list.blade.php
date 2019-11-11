@if ( $Etat == "Actif")
    <option value="modifier" selected>Modifier</option>
    <option value="desactiver">Désactiver</option>
    <option value="supprimer">Supprimer</option>
@elseif ($Etat == "Inactif")
    <option value="modifier" selected>Modifier et activer</option>
    <option value="activer">Activer</option>
    <option value="supprimer">Supprimer</option>
@elseif ($Etat == "")
    <option value="creer" selected>Créer</option>
@endif
