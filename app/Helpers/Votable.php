<?php

namespace App\Helpers;

trait Votable
{
    public function vote(int $vote)
    {
        $this->votes()->attach(auth()->id(), ['vote' => $vote]);
        if($vote < 0) {
            $this->increment('downvotes_count');
        } else {
            $this->increment('upvotes_count');
        }
    }
    public function updateVote(int $vote, int $key=null)
    {
        if($key != null) {
            // Detach vote
            $this->votes()->detach(auth()->id(), ['vote' => $vote]);
            if($key < 0) {
                $this->decrement('downvotes_count');
            }else {
                $this->decrement('upvotes_count');
            }
        } else {
            $this->votes()->updateExistingPivot(auth()->id(), ['vote' => $vote]);
            if($vote < 0) {
                if($this->upvotes_count == 0) {
                    $this->increment('downvotes_count');
                } else {
                    $this->increment('downvotes_count');
                    $this->decrement('upvotes_count');
                }
            } else {
                if($this->downvotes_count == 0) {
                    $this->increment('upvotes_count');
                } else {
                    $this->increment('upvotes_count');
                    $this->decrement('downvotes_count');
                }
            }
        }
    }
}
