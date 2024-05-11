<?php
include_once __DIR__."\..\database\conn.php";
include_once __DIR__."\..\database\operations.php";
include_once __DIR__."\..\images\Image.php";

class User  extends Conn implements operation  {
    private $id;
    private $regDate;
    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $whatsapp_number;
    private $job;
    private $job_other;
    private $country;
    private $city;
    private $job_role;
    private $job_role_other;
    private $company;
    private $company_logo;
    private $status;
    private $updated_at;
    private $conn;


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of regDate
     */ 
    public function getRegDate()
    {
        return $this->regDate;
    }

    /**
     * Set the value of regDate
     *
     * @return  self
     */ 
    public function setRegDate($regDate)
    {
        $this->regDate = $regDate;
        return $this;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }


    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = password_hash($password,PASSWORD_DEFAULT);
        return $this;
    }

    /**
     * Get the value of whatsapp_number
     */ 
    public function getWhatsapp_number()
    {
        return $this->whatsapp_number;
    }

    /**
     * Set the value of whatsapp_number
     *
     * @return  self
     */ 
    public function setWhatsapp_number($whatsapp_number)
    {
        $this->whatsapp_number = $whatsapp_number;
        return $this;
    }

    /**
     * Get the value of job
     */ 
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set the value of job
     *
     * @return  self
     */ 
    public function setJob($job)
    {
        $this->job = $job;
        return $this;
    }

    /**
     * Get the value of job_other
     */ 
    public function getJob_other()
    {
        return $this->job_other;
    }

    /**
     * Set the value of job_other
     *
     * @return  self
     */ 
    public function setJob_other($job_other)
    {
        $this->job_other = $job_other;
        return $this;
    }

    /**
     * Get the value of country
     */ 
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set the value of country
     *
     * @return  self
     */ 
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get the value of city
     */ 
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */ 
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get the value of job_role
     */ 
    public function getJob_role()
    {
        return $this->job_role;
    }

    /**
     * Set the value of job_role
     *
     * @return  self
     */ 
    public function setJob_role($job_role)
    {
        $this->job_role = $job_role;
        return $this;
    }

    /**
     * Get the value of job_role_other
     */ 
    public function getJob_role_other()
    {
        return $this->job_role_other;
    }

    /**
     * Set the value of job_role_other
     *
     * @return  self
     */ 
    public function setJob_role_other($job_role_other)
    {
        $this->job_role_other = $job_role_other;
        return $this;
    }

    /**
     * Get the value of company
     */ 
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set the value of company
     *
     * @return  self
     */ 
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * Get the value of company_logo
     */ 
    public function getCompany_logo()
    {
        return $this->company_logo;
    }

    /**
     * Set the value of company_logo
     *
     * @return  self
     */ 
    public function setCompany_logo($company_logo)
    {
        $this->company_logo = $company_logo;
        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    public function create() {
        $newImage= new Image($this->company_logo['name'],$this->company_logo['tmp_name'],$this->company_logo['size']);
        $uploadDir = __DIR__."/../../../../assets/images".$this->company_logo['name']; 
        $savedImagePath=$newImage->save($uploadDir);
            if ($savedImagePath) {
                $this->company_logo=$savedImagePath;
            } else {
                throw new Exception('Error saving image.'); // Handle image saving errors
            }
        // to insert data at database 
        $query= "INSERT INTO users (firstname,lastname,email,password,whatsapp_number,job,job_other,country,city,job_role,job_role_other,company,company_logo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        return  $this->runDML($query,[$this->firstname,$this->lastname,$this->email,$this->password,$this->whatsapp_number,$this->job,$this->job_other,$this->country,$this->city,$this->job_role,$this->job_role_other,$this->company,$this->company_logo]);
    }

    public function select() {
        // TO SELECT DATA FROM DATABASE 
        $email = $_POST['email'];
        $query = "SELECT * FROM users WHERE email = ?"; 
        return $this->runDQL($query, $email);
    }
    
    public function read() {}

    public function update() {}
    
    public function delete() {}

}
?>