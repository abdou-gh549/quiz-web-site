
<script type="text/javascript">
function removeMatch(matchId){

    if(confirm('Are you sure to remove this record ?')){

        $.ajax({

        url: '<?php echo base_url().'/index.php/formateur/removeMatch/';?>'+matchId,

        type: 'DELETE',

        error: function() {

            alert('Something is wrong');

        },

        success: function(data) {
            if(data == 1){
                $("#"+matchId).remove();

                alert("Record removed successfully");  
            }else if (data == 0){
                alert("Vous ne pouvez pas supprimer ce match car vous n’en êtes pas l’auteur ! ");  
            }
        }

        });
    }
}


</script>

<table class="table table-striped" id="tableOfMatch">
  <thead>
    <tr>
      <th scope="col">Intitule</th>
      <th scope="col">Match Code</th>
      <th scope="col">Date Debut</th>
      <th scope="col">Date Fin</th>
      <th scope="col">Quiz</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    if(isset($match)){
        $question = -1;
        $matchPrintDejaVisiter = array();
        $matchAvisiter = '-1';
        foreach ($match as $row) {
            
            if( ! isset($matchPrintDejaVisiter[$row['match_code']])){
                $matchPrintDejaVisiter[$row['match_code']] = 1;
                $matchAvisiter = $row['match_code'];
            }

            if(strcmp($matchAvisiter, '-1')){
                echo "<tr id=".$row['match_code'].">";
                echo "<td>".$row['match_intitule']."</td>";
                echo "<td>".$row['match_code']."</td>";
                echo "<td>".$row['match_date_debut']."</td>";
                echo "<td>".$row['match_date_fin']."</td>";
                echo "<td>".$row['quiz_intitule']."</td>";
              
                echo '<td>';

                echo form_open( base_url().'/index.php/formateur/viewMatch/'.$row['match_code'].'/'.$quizId);

                $data = array(
                    'class'         => 'btn btn-primary',
                    'name'          => 'button',
                    'id'            => 'button',
                    'value'       => 'afficher');
                echo form_submit($data);
                echo form_close();
                echo form_open( base_url().'/index.php/formateur/editMatch/'.$row['match_code'].'/'.$quizId);
                echo '</td>';
                $data = array(
                    'class'         => 'btn btn-success',
                    'name'          => 'button',
                    'id'            => 'button',
                    'value'       => 'éditer');

                echo '<td>';
                echo form_submit($data);
                echo '</td>';
                echo form_close();

                $data = array(
                    'class'         => 'btn btn-danger remove',
                    'name'          => 'button',
                    'id'            => 'button',
                    'onClick'       => 'removeMatch('."'".$row['match_code']."'".')',
                    'content'       => 'suprimmer');
                echo '<td>';
                echo form_button($data);
                echo '</td>';
                echo "</tr>";


            }
            $matchAvisiter = '-1';
        }
    }
  
  ?>
  </tbody>
</table>
