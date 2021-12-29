<?php

class TourSectionActivity
{
    const TABLE_NAME = 'activity';
    const RELATION_TABLE_NAME = 'tour_activity';
    private int $a_id;
    private string $name;
    private string $location;
    private string $type;
    private string $date;
    private $start_time;
    private $end_time;



    public static function getActivitiesOfTour(PDO $conn, int $ts_id) : array {
        $arr = array();
        $sql = "SELECT * FROM " . self::RELATION_TABLE_NAME . " NATURAL JOIN ".self::TABLE_NAME
            ." WHERE ts_id = :ts_id order by type desc";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ts_id', $ts_id);
        $stmt->execute();
        while( $row = $stmt->fetch()) {
            $arr[$row['a_id']] = TourSectionActivity::makeActivityFromArray($row);
        }
        return $arr;
    }

    public static function makeActivityFromArray(array $row) : TourSectionActivity {
        $activity = new TourSectionActivity();
        $activity->a_id = $row['a_id'];
        $activity->name = $row['name'];
        $activity->location = $row['location'];
        $activity->type = $row['type'];
        $activity->date = $row['date'];
        $activity->start_time = $row['start_time'];
        $activity->end_time = $row['end_time'];
        return $activity;
    }

    public function __toString()
    {
        return $this->name . " " . $this->location . " " . $this->type . " " . $this->date . " " . $this->start_time . " " . $this->end_time;
    }

    /**
     * @return int
     */
    public function getAId(): int
    {
        return $this->a_id;
    }

    /**
     * @param int $a_id
     */
    public function setAId(int $a_id): void
    {
        $this->a_id = $a_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * @param mixed $start_time
     */
    public function setStartTime($start_time): void
    {
        $this->start_time = $start_time;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * @param mixed $end_time
     */
    public function setEndTime($end_time): void
    {
        $this->end_time = $end_time;
    }
}