<?php
namespace Auditor\Repositories;

use Auditor\Entities\PollOption;


class PollOptionRepo extends BaseRepo{

    public function getModel()
    {
        return new PollOption;
    }

    public function getOptions($poll_id)
    {
        $pollOptions = PollOption::where('poll_id', $poll_id)->get();
        return $pollOptions;
    }

} 