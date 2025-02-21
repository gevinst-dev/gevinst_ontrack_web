<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {


    /**
     *
     * Get single user by ID
     *
     */
    public function get($id)
    {
        $query = $this->db->get_where('core_users', array('id' => $id));
        return $result = $query->row_array();
    }


    /**
     *
     * Verify credentials
     *
     */
    public function authenticate($email, $password)
    {
        $email = strtolower($email);
        $query = $this->db->get_where('core_users', array('email' => $email));

        if($query->num_rows() == 0) {
            return FALSE;
        } else {
            $result = $query->row_array();

            $password_valid = password_verify($password, $result['password']);

            if($password_valid) {
                return $result;
            } else {
                log_user(__('Failed authentication: incorrect password.'), $result['id']);
                return FALSE;
            }
        }

    }


    /**
     *
     * Check if email address exists
     *
     */
    public function check_email_address($email)
    {
        $email = strtolower($email);
        $query = $this->db->get_where('core_users', array('email' => $email));

        if($query->num_rows() == 0) {
            return FALSE;
        } else {
            $result = $query->row_array();
            return $result;
        }

    }


    /**
     *
     * Check if password reset key exists
     *
     */
    public function check_reset_key($key)
    {
        $query = $this->db->get_where('core_users', array('password_reset_key' => $key));

        if($query->num_rows() == 0) {
            return FALSE;
        } else {
            return TRUE;
        }

    }

    /**
     *
     * Set password reset key
     *
     */
    public function set_password_reset_key($email)
    {
        $email = strtolower($email);

        $rand_number = rand(100,999999);
        $password_reset_key = md5($rand_number.$email);

        $this->db->where('email', $email);
        $this->db->update('core_users', ["password_reset_key" => $password_reset_key]);

    }



    /**
     *
     * Set password reset key
     *
     */
    public function reset_password($key, $new_password)
    {

        $item = $this->db->get_where('core_users', array('password_reset_key' => $key))->row_array();

        $this->db->where('password_reset_key', $key);
        $this->db->update('core_users', ['password' => $new_password, "password_reset_key" => '']);

        if($this->db->affected_rows() == 0) {
            return FALSE;
        } else {
            return $item;
        }

    }



}
