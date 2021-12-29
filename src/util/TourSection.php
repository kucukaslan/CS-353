<?php

class TourSection
{

    const TOUR_SECTION_TABLE = "tour_section";
    const TOUR_TABLE = "tour";

    private int $t_id;
    private int $ts_id;
    private string $place;
    private string $type;
    private DateTime $start_date;
    private DateTime $end_date;


    public function makeTourSection(PDO $pdo, int $ts_id) : TourSection {
        $ts = new TourSection();
        $sql = "SELECT * FROM ".TourSection::TOUR_SECTION_TABLE." natural join ".TourSection::TOUR_TABLE." WHERE ts_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$ts_id]);
        $row = $stmt->fetch();

        $ts->setTId($row['t_id']);
        $ts->setTsId($row['ts_id']);
        $ts->setPlace($row['place']);
        $ts->setType($row['type']);
        $ts->setStartDate(new DateTime($row['start_date']));
        $ts->setEndDate(new DateTime($row['end_date']));

        return $ts;
    }

    /**
     * @return int
     */
    public function getTId(): int
    {
        return $this->t_id;
    }

    /**
     * @param int $t_id
     */
    public function setTId(int $t_id): void
    {
        $this->t_id = $t_id;
    }

    /**
     * @return int
     */
    public function getTsId(): int
    {
        return $this->ts_id;
    }

    /**
     * @param int $ts_id
     */
    public function setTsId(int $ts_id): void
    {
        $this->ts_id = $ts_id;
    }

    /**
     * @return string
     */
    public function getPlace(): string
    {
        return $this->place;
    }

    /**
     * @param string $place
     */
    public function setPlace(string $place): void
    {
        $this->place = $place;
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
     * @return DateTime
     */
    public function getStartDate(): DateTime
    {
        return $this->start_date;
    }

    /**
     * @param DateTime $start_date
     */
    public function setStartDate(DateTime $start_date): void
    {
        $this->start_date = $start_date;
    }

    /**
     * @return DateTime
     */
    public function getEndDate(): DateTime
    {
        return $this->end_date;
    }

    /**
     * @param DateTime $end_date
     */
    public function setEndDate(DateTime $end_date): void
    {
        $this->end_date = $end_date;
    }

}