<?php
require_once('../connection/connection.php');
require_once('../models/model.php');

Model::setConnection($conn);

class movie extends Model {

    private int $id;
    private string $title;
    private string $description;
    private string $release_date;
    private int $duration;
    private string $rating;
    private string $image;
    private string $url;
    private string $auditorium_id;

    protected static string $table = 'movies';
    protected static array $fillable= ['title', 'description', 'release_date', 'duration', 'rating', 'image', 'url', 'auditorium_id'];

    public function  __construct(array $data ) {
        $this->id = $data['id']??0;
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->release_date = $data['release_date'];
        $this->duration = $data['duration'];
        $this->rating = $data['rating'];
        $this->image = $data['image'];
        $this->url = $data['auditorium_id'];
    }

    //GETTERS
    public function getId(): int {
        return $this->id;
    }
    public function getTitle(): int {
        return $this->title;
    }
    public function getDescription(): int {
        return $this->description;
    }
    public function getRelease_date(): int {
        return $this->release_date;
    }
    public function getDuration(): int {
        return $this->duration;
    }
    public function getRating(): int {
        return $this->rating;
    }
    public function getImage(): int {
        return $this->image;
    }
    public function getUrl(): int {
        return $this->url;
    }
    public function getAuditorium_id(): int {
        return $this->auditorium_id;
    }

    //SETTERS
    public function setID(int $id): int {
        return $this->id = $id;
    }
    public function setTitle(string $title): string {
        return $this->title = $title;
    }
    public function setDescription(string $description): string {
        return $this->description = $description;
    }
    public function setRelease_date(string $release_date): string {
        return $this->release_date = $release_date;
    }
    public function setDuration(string $duration): string {
        return $this->duration = $duration;
    }
    public function setRating(string $rating): string {
        return $this->rating = $rating;
    }
    public function setImage(string $image): string {
        return $this->image = $image;
    }
    public function setUrl(string $url): string {
        return $this->url = $url;
    }
    public function setAuditorium_id(string $auditorium_id): string {
        return $this->auditorium_id = $auditorium_id;
    }
    
    public function toArray():array {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'release_date' => $this->getRelease_date(),
            'duration' => $this->getDuration(),
            'rating' => $this->getRating(),
            'image' => $this->getImage(),
            'url' => $this->getUrl(),
            'auditorium_id'=> $this->getAuditorium_id()
        ];
    }
}