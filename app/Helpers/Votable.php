<?php

namespace App\Helpers;

trait Votable
{
    public function vote(int $vote)
    {
        $this->votes()->attach(auth()->id(), ['vote' => $vote]);
        if($vote < 0) {
            $this->increment('report_spam_count');
        } else {
            $this->increment('likes_count');
        }
    }
    public function updateVote(int $vote, int $key=null)
    {
        if($key != null) {
            // Detach vote
            $this->votes()->detach(auth()->id(), ['vote' => $vote]);
            if($key < 0) {
                $this->decrement('report_spam_count');
            }else {
                $this->decrement('likes_count');
            }
        } else {
            $this->votes()->updateExistingPivot(auth()->id(), ['vote' => $vote]);
            if($vote < 0) {
                if($this->likes_count == 0) {
                    $this->increment('report_spam_count');
                } else {
                    $this->increment('report_spam_count');
                    $this->decrement('likes_count');
                }
            } else {
                if($this->report_spam_count == 0) {
                    $this->increment('likes_count');
                } else {
                    $this->increment('likes_count');
                    $this->decrement('report_spam_count');
                }
            }
        }
    }
}
