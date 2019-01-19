<?php echo validation_errors(); ?>
<?php echo form_open('compte/connecter') ?>
<
<section>
<label>Tapez votre recherche ici :</label><br>
<input type="text" name="pseudo" />
<input type="text" name="mdp" />
<input type="submit" value="Connexion"/>
</form>
</section>


<!-- Modal 
<div class="modal fade" id="AdminLoginModel" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container" style="margin-top:30px">
                            <div class="col-md-12">
                                <div class="login-panel panel panel-default">
                                    <div class="panel-heading justify-content-md-center">
                                        <h3 class="login_title">Admin</h3>
                                    </div>
                                    <div class="panel-body">
                                        <form role="form">
                                            <fieldset>
                                                <div class="form-group">
                                                    <input class="form-control" placeholder="Pseudo" name="pseudo" type="text" autofocus="">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" placeholder="Password" name="mdp" type="password" value="">
                                                </div>
                                                <input type="submit" value="Connexion" class="btn btn-primary custum-btn col-md-5 margin_top_btn"/>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

-->