<?php $this->load->view('templates/header.php');?>
<div id="main">
    <div id="subheader">
        Register
    </div>

    <div id="content">
        <?php echo form_open('users/create', array('id'=>'register_form', 'method'=>'post')); ?>
            <p class="error_text">
                <?php echo isset($error_message)?$error_message:''; ?>
            </p>
            <p style="text-align: right">
                <span class="required">*</span> Required
            </p>
            <dl>
                <dt>
                    <label for="title">Title</label>
                </dt>
                <dd>
                    <input type="text" class="textbox" name="title" id="title" value="<?php echo $this->input->post('title');?>" />
                </dd>

                <dt>
                    <label for="first_name" <?php echo isset($this->validation->first_name_error)?'class="error_text"':'' ?>>First Name <span class="required">*</span>
                        <span class="feedback">
                            <?php echo isset($this->validation->first_name_error)?$this->validation->first_name_error:'';?>
                        </span>
                    </label>
                </dt>
                <dd>
                    <input type="text" class="textbox" name="first_name" id="first_name" value="<?php echo $this->input->post('first_name');?>" />
                </dd>

                <dt>
                    <label for="middle_name">Middle Name</label>
                </dt>
                <dd>
                    <input type="text" class="textbox" name="middle_name" id="middle_name" value="<?php echo $this->input->post('middle_name');?>" />
                </dd>

                <dt>
                    <label for="last_name" <?php echo isset($this->validation->last_name_error)?'class="error_text"':'' ?>>Last Name <span class="required">*</span>
                        <span class="feedback">
                            <?php echo isset($this->validation->last_name_error)?$this->validation->last_name_error:'';?>
                        </span>
                    </label>
                </dt>
                <dd>
                    <input type="text" class="textbox" name="last_name" id="last_name" value="<?php echo $this->input->post('last_name');?>" />
                </dd>

                <dt>
                    <label for="suffix">Suffix</label>
                </dt>
                <dd>
                    <input type="text" class="textbox" name="suffix" id="suffix" value="<?php echo $this->input->post('suffix');?>" />
                </dd>

                <dt>
                    <label for="gender" <?php echo isset($this->validation->gender_error)?'class="error_text"':'' ?>>Gender <span class="required">*</span>
                        <span class="feedback">
                            <?php echo isset($this->validation->gender_error)?$this->validation->gender_error:'';?>
                        </span>
                    </label>
                </dt>
                <dd>
                    <input type="radio" name="gender" value="M" <?php echo $this->validation->set_radio('gender', 'M');?> />Male
                    <input type="radio" name="gender" value="F" <?php echo $this->validation->set_radio('gender', 'F');?> />Female<br />
                </dd>

                <dt>
                    <label for="birthdate" <?php echo isset($this->validation->birthdate_error)?'class="error_text"':'' ?>>Date of Birth <span class="required">*</span>
                        <span class="feedback">
                            <?php echo isset($this->validation->birthdate_error)?$this->validation->birthdate_error:'';?>
                        </span>
                    </label>
                </dt>
                <dd>
                    <input type="text" class="textbox" name="birthdate" id="birthdate" value="<?php echo $this->input->post('birthdate');?>" /><br />(mm/dd/yyyy)
                </dd>

                <dt>
                    <label for="address1" <?php echo isset($this->validation->address1_error)?'class="error_text"':'' ?>>Address <span class="required">*</span>
                        <span class="feedback">
                            <?php echo isset($this->validation->address1_error)?$this->validation->address1_error:'';?>
                        </span>
                    </label>
                </dt>
                <dd>
                    <input type="text" class="textbox" name="address1" id="address1" value="<?php echo $this->input->post('address1');?>" />
                </dd>

                <dt>
                    <label for="address2" style="visibility: hidden">.</label>
                </dt>
                <dd>
                    <input type="text" class="textbox" name="address2" id="address2" value="<?php echo $this->input->post('address2');?>" />
                </dd>

                <dt>
                    <label for="city" <?php echo isset($this->validation->city_error)?'class="error_text"':'' ?>>City <span class="required">*</span>
                        <span class="feedback">
                            <?php echo isset($this->validation->city_error)?$this->validation->city_error:'';?>
                        </span>
                    </label>
                </dt>
                <dd>
                    <input type="text" class="textbox" name="city" id="city" value="<?php echo $this->input->post('city');?>" />
                </dd>

                <dt>
                    <label for="state" <?php echo isset($this->validation->state_error)?'class="error_text"':'' ?>>State/Province <span class="required">*</span>
                        <span class="feedback">
                            <?php echo isset($this->validation->state_error)?$this->validation->state_error:'';?>
                        </span>
                    </label>
                </dt>
                <dd>
                    <input type="text" class="textbox" name="state" id="state" value="<?php echo $this->input->post('state');?>" />
                </dd>

                <dt>
                    <label for="zip" <?php echo isset($this->validation->zip_error)?'class="error_text"':'' ?>>Zip/Postal Code <span class="required">*</span>
                        <span class="feedback">
                            <?php echo isset($this->validation->zip_error)?$this->validation->zip_error:'';?>
                        </span>
                    </label>
                </dt>
                <dd>
                    <input type="text" class="textbox" name="zip" id="zip" value="<?php echo $this->input->post('zip');?>" />
                </dd>

                <dt>
                    <label for="country" <?php echo isset($this->validation->country_error)?'class="error_text"':'' ?>>Country <span class="required">*</span>
                        <span class="feedback">
                            <?php echo isset($this->validation->country_error)?$this->validation->country_error:'';?>
                        </span>
                    </label>
                </dt>
                <dd>
                    <input type="text" class="textbox" name="country" id="country" value="<?php echo $this->input->post('country');?>" />
                </dd>

                <dt>
                    <label for="home_phone" <?php echo isset($this->validation->home_phone_error)?'class="error_text"':'' ?>>Home Phone <span class="required">*</span>
                        <span class="feedback">
                            <?php echo isset($this->validation->home_phone_error)?$this->validation->home_phone_error:'';?>
                        </span>
                    </label>
                </dt>
                <dd>
                    <input type="text" class="textbox" name="home_phone" id="home_phone" value="<?php echo $this->input->post('home_phone');?>" />
                </dd>

                <dt>
                    <label for="work_phone">Work Phone</label>
                </dt>
                <dd>
                    <input type="text" class="textbox" name="work_phone" id="work_phone" value="<?php echo $this->input->post('work_phone');?>" />
                </dd>

                <dt>
                    <label for="fax">Fax</label>
                </dt>
                <dd>
                    <input type="text" class="textbox" name="fax" id="fax" value="<?php echo $this->input->post('fax');?>" />
                </dd>

                <dt>
                    <label for="email" <?php echo isset($this->validation->email_error)?'class="error_text"':'' ?>>Email <span class="required">*</span>
                        <span class="feedback">
                            <?php echo isset($this->validation->email_error)?$this->validation->email_error:'';?>
                        </span>
                    </label>
                </dt>
                <dd>
                    <input type="text" class="textbox" name="email" id="email" value="<?php echo $this->input->post('email');?>" /><br />(example555@yahoo.com)
                </dd>

                <dt>
                    <label for="password" <?php echo isset($this->validation->password_error)?'class="error_text"':'' ?>>Password <span class="required">*</span>
                        <span class="feedback">
                            <?php echo isset($this->validation->password_error)?$this->validation->password_error:'';?>
                        </span>
                    </label>
                </dt>
                <dd>
                    <input type="password" class="textbox" name="password" id="password" value="<?php echo $this->input->post('password');?>" /><br />Minimum six characters. Case sensitive.
                </dd>

                <dt>
                    <label for="retyped_password" <?php echo isset($this->validation->retyped_password_error)?'class="error_text"':'' ?>>Re-type Password <span class="required">*</span>
                        <span class="feedback">
                            <?php echo isset($this->validation->retyped_password_error)?$this->validation->retyped_password_error:'';?>
                        </span>
                    </label>
                </dt>
                <dd>
                    <input type="password" class="textbox" name="retyped_password" id="retyped_password" value="<?php echo $this->input->post('retyped_password');?>" />
                </dd>
            </dl>
            <p style="margin-left: 170px">
                <input type="submit" class="button" name="submit" value="Create My Account" />
                <input type="submit" class="button" name="submit" value="Cancel" />
            </p>
        </form>
    </div><!-- End of content div -->
</div><!-- End of div main -->
<?php $this->load->view('templates/footer.php');?>
