
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Intitule</th>
      <th scope="col">Propriétaire</th>
      <th scope="col">Descreptif</th>
      <th scope="col">Nombre des Matchs</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    if(isset($quiz)){
        foreach ($quiz as $row) {
            echo "<td>".$row['quiz_intitule']."</td>";
            echo "<td>".$row['cpt_pseudo']."</td>";
            echo "<td>".$row['quiz_descriptif']."</td>";
            echo "<td>".$row['quiz_matchNumber']."</td>";
            
            
            echo '<td>';

            echo form_open( base_url().'/index.php/formateur/viewMatchOfQuiz/'.$row['quiz_id']);

            $data = array(
                'class'         => 'btn btn-primary',
                'name'          => 'button',
                'id'            => 'button',                
                'value'       => 'Afficher Les Matchs'
            );
            if($row['quiz_matchNumber'] == 0){
                $data['disabled']= 'disabled';   
            }
            echo form_submit($data);
            echo form_close();

            echo '</td>';
            echo form_open( base_url().'/index.php/formateur/newMatch/'.$row['quiz_id']);

            $data = array(
                'class'         => 'btn btn-success',
                'name'          => 'button',
                'id'            => 'button',
                'value'       => 'Créer un match');

            echo '<td>';
            echo form_submit($data);
            echo form_close();

            echo '</td>';
            echo "</tr>";

        }

    }
  
  ?>
  </tbody>
</table>
