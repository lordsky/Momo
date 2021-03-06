<?php 

/** 
 * Copyright 2013, ETH Z�rich
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License. 
 */


//
// some preliminary logic with regard to call mode

// determine what action to call
$component_mode == "new" ? $action = "/manageprojects/createproject" : $action = "/manageprojects/updateproject";

?>

<script type="text/javascript">

	//
	// submits the indicated form
	//
	function submitForm() {
		return isValidForm();
	}

	//
	// cancels the form
	//
	function cancelForm() {
		document.location = "/manageprojects";
	}


	//
	// validates the project form
	//
	// the project form is valid, if
	// 	- it has a name that is at least 5 and less than 50 chars long
	//
	function isValidForm() {

		var form = $("#form");
		
		var validated = true;
		var validationMsg = "";

		var nameValue = $.trim($(form).find("input[name=projectName]").val());

		// validate that name field has a value
		if ( nameValue == "" ) {
			validated = false;
			validationMsg += "The field <strong>Name</strong> must be completed.";
		}
		// validate that name field is at least 5 chars long
		else if (nameValue.length < 5) {
			validated = false;
			validationMsg += "The field <strong>Name</strong> must be at least 5 characters long.";
		}
		
		if ( ! validated ) {
			displayAlert("alertBox", validationMsg, "error");
		}

		return validated;
	}

</script>

<!-- begin: component_project_form -->
<div class="row">
	<div class="offset2 span8">
	
		<div class="momo_panel">
	
			<div class="momo_panel_header">
				<h4><?php echo $component_title ?></h4>
			</div>
	
	    	<div class="well momo_panel_body"> 
	    		
	    		<?php 		
	    			// load alert box widget
	    			$this->load->view("widgets/widget_alert_box.php");
	    		?>
	
				<form id="form" action="<?php echo $action; ?>" method="post" class="form-horizontal" style="margin-left: 0px;">
					<fieldset>
					
						<div class="control-group">
							<label for="teamName" class="control-label">Name</label>
							<div class="controls">
								<?php $component_mode == "edit" ? $name = $component_edit_target->getName() : $name = "" ?>
								<input type="text" name="projectName" value="<?php echo $name; ?>" class="span3 input-xlarge" maxlength="50" tabindex="1">
							</div>
						</div>
						
						<div class="control-group">
							<label for="assignedTeams" class="control-label">Assigned Teams</label>
							<div class="controls">
								<select id="assignedTeams" multiple="multiple" name="assignedTeams[]" class="span2" tabindex="2">
									
									<?php foreach ($component_teams_active as $curTeam) : ?>
									
										<?php $selected = "" ?>
										<?php if ( $component_mode == "edit" ) : ?>
									
											<?php if ($component_edit_target->isAssignedTeam($curTeam)) : ?>
												
												<?php $selected = "selected='selected'" ?>
										
											<?php endif; ?>
										
										<?php endif; ?>
									
										<option value="<?php echo $curTeam->getId(); ?>" <?php echo $selected; ?>> <?php echo $curTeam->getName(); ?></option>
										
									<?php endforeach; ?>
									
								</select>
							</div>
						</div>
	
						<div class="control-group">
							<label for="assignedUsers" class="control-label">Assigned Users</label>
							<div class="controls">
								<select id="assignedUsers" multiple="multiple" name="assignedUsers[]" class="span2" tabindex="3">
								
									<?php foreach ($component_users_active as $curUser) : ?>
									
										<?php $selected = "" ?>
										<?php if ( $component_mode == "edit" ) : ?>
									
											<?php if ($component_edit_target->isAssignedUser($curUser)) : ?>
												
												<?php $selected = "selected='selected'" ?>
										
											<?php endif; ?>
										
										<?php endif; ?>
									
										<option value="<?php echo $curUser->getId(); ?>" <?php echo $selected; ?>><?php echo $curUser->getFirstName() . " " . $curUser->getLastName(); ?></option>
										
									<?php endforeach; ?>
								
								</select>
							</div>
						</div>
						
						<div class="control-group">
							<label for="enabled" class="control-label">Enabled</label>
							<div class="controls">
							
								<select id="enabled" name="enabled" class="span1" tabindex="4">
									
									<?php foreach (\momo\core\helpers\FormHelper::$binaryOptionsYesNo as $curOptVal => $curOptText) : ?>
									
										<?php $selected = "" ?>
										<?php if ( $component_mode == "edit" ) : ?>
																							
											<?php if ($component_edit_target->getEnabled() == (bool) $curOptVal) : ?>
												
												<?php $selected = "selected='selected'" ?>
										
											<?php endif; ?>
										
										<?php endif; ?>
									
										<option value="<?php echo $curOptVal; ?>" <?php echo $selected; ?>><?php echo $curOptText; ?></option>
										
									<?php endforeach; ?>
									
								</select>
							</div>
						</div>
						
						<div class="form-actions">
							<button class="btn btn-mini btn-primary" onclick="return submitForm();" tabindex="5">save</button>
							<button class="btn btn-mini" onclick="cancelForm(); return false;" tabindex="6">cancel</button>
						</div>
						
						<?php if ( $component_mode == "edit" ) : ?>
							<!-- the id of the edit target -->
							<input type="hidden" name="projectId" value="<?php echo $component_edit_target->getId(); ?>">	
						<?php endif; ?>	
						
					</fieldset>
	
				</form>
			</div>
		</div>
			 
    </div>
</div>

<!-- end: component_project_form -->
