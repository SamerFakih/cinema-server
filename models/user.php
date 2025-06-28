<?php
require_once('../models/model.php');

Model::setConnection($conn);

class User extends Model {

    private int $id;
    private string $name;
    private string $email;
    private string $mobile;
    private string $password;
    private string $dob;
    private string $government_id;
    private int $admin;

    protected static string $table = 'users';
    protected static array $fillable = ['name', 'email', 'mobile', 'password', 'dob', 'government_id_image','admin'];


    public function __construct(array $data) {
        $this->id = $data["id"] ?? 0;
        $this->name = $data["name"];
        $this->email = $data["email"];
        $this->mobile = $data["mobile"];
        $this->password = $data["password"];
        $this->dob = $data['dob'];
        $this->government_id = $data["government_id_image"];
        $this ->admin = $data["admin"] ?? 0;
    }

    // Getters
    public function getId(): int {
        return $this->id;
    }
    public function getName(): string {
        return $this->name;
    }
    public function getEmail(): string {
        return $this->email;
    }
    public function getMobile(): string {
        return $this->mobile;
    }
    public function getPassword(): string {
        return $this->password;
    }
    public function getDob(): string {
        return $this->dob;
    }
    public function getGovernmentId(): string {
        return base64_encode($this->government_id);
    }

    public function getAdmin():int {
        return $this->admin;
    }

    // Setters
    public function setName(string $name): string {
        return $this->name = $name;
    }
    public function setEmail(string $email): string {
        return $this->email = $email;
    }
    public function setMobile(string $mobile): string {
        return $this->mobile = $mobile;
    }
    public function setPassword(string $password): string {
        return $this->password = $password;
    }
    public function setDob(string $dob): void {
        $this->dob = $dob;
    }
    public function setGovernmentId(string $government_id): string {
        return $this->government_id = $government_id;
    }
    public function setAdmin(int $admin) : int {
        return $this->admin = $admin;
    }

    public function toArray(): array {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'mobile' => $this->getMobile(),
            'password' => $this->getPassword(),
            'dob' => $this->getDob(),
            'government_id_image' => $this->getGovernmentId(),
            'admin' => $this->getAdmin()
        ];
    }
}
