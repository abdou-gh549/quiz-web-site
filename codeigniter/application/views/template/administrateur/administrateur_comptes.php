<?php 
    echo "<pre>";
  //  print_r($comptes);
    echo "</pre>";

?>

<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Pseudo</th>
      <th scope="col">Nom</th>
      <th scope="col">Prénome</th>
      <th scope="col">Compte type</th>
      <th scope="col">Compte état</th>
      
      
    </tr>
  </thead>
  <tbody>
  <?php 
    foreach($comptes as $cmpt){
      echo "<tr>";
      echo "<td>".$cmpt["cpt_pseudo"]."</td>";  
      echo "<td>".$cmpt["cpt_nom"]."</td>";  
      echo "<td>".$cmpt["cpt_prenom"]."</td>";  
      if($cmpt['cpt_type'] == 1){
        echo "<td>Administrateur</td>";  
      }else if ($cmpt['cpt_type'] == 2){
        echo "<td>Formateur</td>";  

      }else {
        echo "<td>Unknow</td>";  
      }

      echo "<td>";
      if($cmpt['cpt_actif'] == 0){
          echo "désactivé";
      }else 
        echo "activé";
      echo "</td>";  

      echo "</tr>";

    }
  
  ?>
  </tbody>
</table>