<?php

namespace App\Livewire\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Article;
use App\Models\Journal;
use Livewire\Component;
use App\Mail\ReviewStatus;
use App\Mail\ReviewRequest;
use App\Models\JournalUser;
use App\Mail\ArticleReturns;
use App\Models\Notification;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Models\ArticleReview;
use App\Models\ArticleStatus;
use App\Models\ReviewMessage;
use App\Models\ReviewSection;
use Livewire\WithFileUploads;
use App\Models\ArticleComment;
use App\Mail\ArticleAssignment;
use App\Models\EditorChecklist;
use App\Models\ReviewSectionsComment;
use App\Models\ReviewSectionsGroup;
use Illuminate\Support\Facades\Mail;

class Articles extends Component
{
    use WithPagination, WithFileUploads;

    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;

    public $record;
    public $status;
    public $deleteModal = false;
    public $description;
    public $journal;
    public $checklist;

    public function mount(Request $request)
    {
        $this->status = $request->status;
    }

    public function render()
    {
        $this->checklist = EditorChecklist::all();


        if ($this->record) {
            foreach ($this->record->editorChecklists as $key => $value) {
                $this->check[$value->id] = true;
            }
        }

        $journal  = Journal::where('uuid', session('journal'))->first();
        $this->journal = $journal;

        $articles = $journal?->articles();
        if ($this->status == 'pending') {
            $status = ArticleStatus::whereIn('code', ['001', '005', '012'])->get()->pluck('id')->toArray();

            $articles->when($this->query, function ($query, $search) {
                return $query->where(function ($query) {
                    $query->where('title', 'ilike', '%' . $this->query . '%');
                });
            })
                ->where('user_id', auth()->user()->id)
                ->whereIn('article_status_id', $status);
        }


        if ($this->status == 'onprogress') {
            $status = ArticleStatus::whereIn('code', ['002', '006', '008', '009', '010', '011', '013', '018'])->get()->pluck('id')->toArray();

            $articles->when($this->query, function ($query, $search) {
                return $query->where(function ($query) {
                    $query->where('title', 'ilike', '%' . $this->query . '%');
                });
            })
                ->where('user_id', auth()->user()->id)
                ->whereIn('article_status_id', $status);
        }

        if ($this->status == 'with_decisions') {
            $status = ArticleStatus::whereIn('code', ['007', '014', '015', '021'])->get()->pluck('id')->toArray();

            $articles->when($this->query, function ($query, $search) {
                return $query->where(function ($query) {
                    $query->where('title', 'ilike', '%' . $this->query . '%');
                });
            })
                ->where('user_id', auth()->user()->id)
                ->whereIn('article_status_id', $status);
        }

        if ($this->status == 'submitted') {
            $status = ArticleStatus::whereIn('code', ['002'])->get()->pluck('id')->toArray();

            $articles->when($this->query, function ($query, $search) {
                return $query->where(function ($query) {
                    $query->where('title', 'ilike', '%' . $this->query . '%');
                });
            })
                ->where('user_id', '<>', auth()->user()->id)
                ->whereIn('article_status_id', $status);
        }


        if ($this->status == 'resubmitted') {
            $status = ArticleStatus::whereIn('code', ['006'])->get()->pluck('id')->toArray();

            $articles->when($this->query, function ($query, $search) {
                return $query->where(function ($query) {
                    $query->where('title', 'ilike', '%' . $this->query . '%');
                });
            })
                ->where('user_id', '<>', auth()->user()->id)
                ->whereIn('article_status_id', $status);
        }


        if ($this->status == 'on_review') {
            $status = ArticleStatus::whereIn('code', ['003', '008', '009', '010'])->get()->pluck('id')->toArray();

            $articles->when($this->query, function ($query, $search) {
                return $query->where(function ($query) {
                    $query->where('title', 'ilike', '%' . $this->query . '%');
                });
            })

                ->where('user_id', '<>', auth()->user()->id)
                ->whereIn('article_status_id', $status);

            $juser = $this->journal->journal_us()->where('user_id', auth()->user()->id)->first();

            if ($juser->hasRole('Associate Editor')) {
                $articles = $articles->whereHas('article_journal_users', function ($query) use ($juser) {
                    $query->where('journal_user_id', $juser->id);
                });
            }
        }


        if ($this->status == 'production') {
            $status = ArticleStatus::whereIn('code', ['018'])->get()->pluck('id')->toArray();

            $articles->when($this->query, function ($query, $search) {
                return $query->where(function ($query) {
                    $query->where('title', 'ilike', '%' . $this->query . '%');
                });
            })
                ->where('user_id', '<>', auth()->user()->id)
                ->whereIn('article_status_id', $status);
        }


        if ($this->status == 'returned_to_author' || $this->status == 'returned') {
            $status = ArticleStatus::whereIn('code', ['004', '019', '020'])->get()->pluck('id')->toArray();

            $articles->when($this->query, function ($query, $search) {
                return $query->where(function ($query) {
                    $query->where('title', 'ilike', '%' . $this->query . '%');
                });
            })->whereIn('article_status_id', $status);

            if ($this->status == 'returned_to_author') {
                $articles =  $articles->where('user_id', '<>', auth()->user()->id);
            }

            if ($this->status == 'returned') {
                $articles =  $articles->where('user_id', auth()->user()->id);
            }
        }


        if ($this->status == 'rejected') {
            $status = ArticleStatus::whereIn('code', ['015'])->get()->pluck('id')->toArray();

            $articles->when($this->query, function ($query, $search) {
                return $query->where(function ($query) {
                    $query->where('title', 'ilike', '%' . $this->query . '%');
                });
            })
                ->where('user_id', '<>', auth()->user()->id)
                ->whereIn('article_status_id', $status);
        }


        if ($this->status == 'pending_publications') {
            $status = ArticleStatus::whereIn('code', ['011', '013'])->get()->pluck('id')->toArray();

            $articles->when($this->query, function ($query, $search) {
                return $query->where(function ($query) {
                    $query->where('title', 'ilike', '%' . $this->query . '%');
                });
            })
                ->where('user_id', '<>', auth()->user()->id)
                ->whereIn('article_status_id', $status);
        }


        if ($this->status == 'online_first') {
            $status = ArticleStatus::whereIn('code', ['014'])->get()->pluck('id')->toArray();

            $articles->when($this->query, function ($query, $search) {
                return $query->where(function ($query) {
                    $query->where('title', 'ilike', '%' . $this->query . '%');
                });
            })
                ->whereNull('issue_id')
                ->whereIn('article_status_id', $status);
        }


        if ($this->status == 'published') {
            $status = ArticleStatus::whereIn('code', ['014'])->get()->pluck('id')->toArray();

            $articles->when($this->query, function ($query, $search) {
                return $query->where(function ($query) {
                    $query->where('title', 'ilike', '%' . $this->query . '%');
                });
            })
                ->whereIn('article_status_id', $status);
        }

        $articles = $articles->paginate(20);

        return view('livewire.backend.articles', compact('articles', 'journal'));
    }

    public function confirmDelete(Article $article)
    {
        $this->record = $article;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $this->record->files()->delete();
        $this->record->delete();

        session()->flash('response', [
            'status'  => '',
            'message' => 'Manuscript is Saved and Submitted successfully'
        ]);

        $this->deleteModal = false;
    }

    public $roles;
    public $isOpen = false;

    public function openDrawer(Article $article)
    {
        $this->dispatch('contentChanged');
        $this->record = $article;
        $this->isOpen = true;
    }

    public function closeDrawer()
    {
        $this->isOpen = false;
    }



    public $isOpenA = false;

    public function openDrawerA(Article $article)
    {
        $this->record  = $article;
        $this->isOpenA = true;
    }

    public function closeDrawerA()
    {
        $this->isOpenA = false;
    }



    public $isOpenB = false;
    public $rev_count = 0;

    public function openDrawerB(Article $article, $string, $role)
    {
        $this->dispatch('contentChanged');

        $this->record  = $article;

        $this->rev_count = $article->article_journal_users()->whereHas('roles', function ($query) {
            $query->where('name', 'Reviewer');
        })->get()->count();

        // dd($this->rev_count);

        $this->searchUser($string, $role);

        $this->scope   = true;
        $this->isOpenB = true;
    }



    public function closeDrawerB()
    {
        $this->isOpenB = false;
    }



    public $isOpenC = false;

    public function openDrawerC(Article $article)
    {
        $this->dispatch('contentChanged');
        $this->record  = $article;
        $this->isOpenC = true;
    }

    public function closeDrawerC()
    {
        $this->isOpenC = false;
    }



    public $isOpenD = false;

    public function openDrawerD(Article $article)
    {
        $this->dispatch('contentChanged');
        $this->record  = $article;
        $this->isOpenD = true;
    }

    public function closeDrawerD()
    {
        $this->isOpenD = false;
    }



    public $isOpenE = false;

    public function openDrawerE(Article $article)
    {
        $this->dispatch('contentChanged');
        $this->record  = $article;
        $this->isOpenE = true;
    }

    public function closeDrawerE()
    {
        $this->isOpenE = false;
    }



    public $isOpenF = false;

    public function openDrawerF(Article $article)
    {
        $this->dispatch('contentChanged');
        $this->record  = $article;
        $this->isOpenF = true;
    }

    public function closeDrawerF()
    {
        $this->isOpenF = false;
    }


    public $isOpenG = false;

    public function openDrawerG(Article $article)
    {
        $this->dispatch('contentChanged');
        $this->record  = $article;
        $this->isOpenG = true;
    }

    public function closeDrawerG()
    {
        $this->isOpenG = false;
    }


    public $isOpenH = false;

    public function openDrawerH(Article $article)
    {
        $this->dispatch('contentChanged');
        $this->record  = $article;
        $this->isOpenH = true;
    }

    public function closeDrawerH()
    {
        $this->isOpenH = false;
    }



    public $isOpenI = false;

    public function openDrawerI(Article $article)
    {
        $this->dispatch('contentChanged');
        $this->record  = $article;
        $this->isOpenI = true;
    }

    public function closeDrawerI()
    {
        $this->isOpenI = false;
    }



    public $eprocess = null;
    public function getCheckList()
    {
        // dd($this->review_status); 

        if ($this->review_status == '018') {
            $this->eprocess = '009'; //Accepted

        } else if ($this->review_status == '019') {
            $this->eprocess = '007'; //Minor

        } else if ($this->review_status == '020') {
            $this->eprocess = '005'; //Major

        } else if ($this->review_status == '015') {
            $this->eprocess = '004'; //Rejected
        }


        $status = \App\Models\EditorialProcess::whereIn('code', ['004', '005', '007', '009'])->get()->pluck('id')->toArray();

        $remove = EditorChecklist::whereIn('editorial_process_id', $status)->get()->pluck('id')->toArray();

        $this->record->editorChecklists()->detach($remove);
    }



    public function recommendations()
    {
        ArticleComment::create(
            [
                'article_id'  => $this->record->id,
                'user_id'     => auth()->user()->id,
                'send_to'     => 'Chief Editor',
                'description' => $this->description
            ]
        );

        $status = $this->articleStatus('009');

        //Update Notifications
        $notified = $this->record->notifications()->where('journal_user_id', $this->journal->journal_us()->where('user_id', auth()->user()->id)->first()->id);

        if ($notified->exists()) {
            $notified->first()->update([
                'status' => 0
            ]);
        }


        $journal_user = $this->journal->journal_us()->whereHas('roles', function ($query) {
            $query->where('name', 'Chief Editor');
        })->first();

        Notification::create([
            'article_id'      => $this->record->id,
            'journal_user_id' => $journal_user->id,
            'status'          => 1
        ]);



        $this->record->update([
            'article_status_id' => $status->id,
            'deadline'          => Carbon::now()->addDays($status->max_days)
        ]);

        session()->flash('response', [
            'status'  => 'success',
            'message' => 'This Manuscript is Returned back to Chief Editor successfully, with Recommendations'
        ]);
    }


    public $check = [];

    public function selectCheck($check)
    {


        $value = 0;
        if ($this->check[$check]) {
            $value = 1;
        }

        $this->record->editorChecklists()->sync([$check => [
            'value'   => $value,
            'user_id' => auth()->user()->id
        ]], false);

        // $this->dispatch('contentChanged');

    }

    public function guidelineCompliance($compliance)
    {
        $status = $this->articleStatus($compliance);

        if ($compliance == '004') {

            $this->validate([
                'description' => 'required|string'
            ]);

            ArticleComment::create(
                [
                    'article_id'  => $this->record->id,
                    'user_id'     => auth()->user()->id,
                    'description' => $this->description
                ]
            );

            session()->flash('response', [
                'status'  => '',
                'message' => 'This Manuscript is Returned back to Author successfully'
            ]);


            //updating notification
            $active_note = $this->record->notifications()->where('journal_user_id', $this->journal->journal_us()->where('user_id', auth()->user()->id)->first()->id)->first();

            if (!is_null($active_note)) {
                $active_note->update([
                    'status' => 0
                ]);
            }


            $journal_user = $this->journal->journal_us()->where('user_id', $this->record->user_id)->first();
            $notify = new Notification;
            $notify->article_id = $this->record->id;
            $notify->journal_user_id = $journal_user->id;
            $notify->status = 1;
            $notify->save();


            if (ReviewMessage::where('category', 'Article Return')->count() > 0) {
                Mail::to($this->record->author->email)
                    ->send(new ArticleReturns($this->record, $this->description));
            }
        } else {
            //updating notification
            $notefied = $this->record->notifications()->where('journal_user_id', $this->journal->journal_us()->where('user_id', auth()->user()->id)->first()->id);

            if ($notefied->exists()) {
                $notefied->first()->update([
                    'status' => 0
                ]);
            }

            $journal_user = $this->journal->journal_us()->whereHas('roles', function ($query) {
                $query->where('name', 'Chief Editor');
            })->first();

            Notification::create([
                'article_id'      => $this->record->id,
                'journal_user_id' => $journal_user->id,
                'status'          => 1
            ]);

            session()->flash('response', [
                'status'  => 'info',
                'message' => 'This Manuscript is Saved and Submitted for further editorial decision'
            ]);
        }

        $this->record->update([
            'article_status_id' => $status->id,
            'deadline'          => Carbon::now()->addDays($status->max_days)
        ]);

        $this->closeDrawer();
    }

    public function articleStatus($code)
    {
        return ArticleStatus::where('code', $code)->first();
    }








    public $search_user;
    public $username;
    public $users_x = [];
    public $users   = [];

    public function searchUser($string, $role)
    {
        $this->search_user = $string;
        $reviewers = $this->record->article_journal_users()->whereHas('roles', function ($query) {
            $query->where('name', 'Reviewer');
        })->pluck('user_id');


        $selectedUsers = collect($this->users_x)->pluck('user_id')->toArray();

        $this->users = JournalUser::whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        })
            ->whereNotIn('user_id', $reviewers)
            ->whereNotIn('user_id', $selectedUsers)
            ->when($this->search_user, function ($query) {
                return $query->whereHas('user', function ($query) {
                    $query->where('first_name', 'ilike', '%' . $this->search_user . '%')->orWhere('middle_name', 'ilike', '%' . $this->search_user . '%')->orWhere('last_name', 'ilike', '%' . $this->search_user . '%');
                });
            })
            ->where('journal_id', $this->journal->id)
            ->limit('10')->get();
    }


    public function selectUser(JournalUser $user)
    {
        if (!in_array($user, $this->users_x)) {
            $this->users_x[] = $user;
        }
        $this->username    = '';
        $this->users       = [];
        $this->search_user = '';

        $this->searchUser($this->search_user, 'Reviewer');
    }

    public function removeSelectedUser($userId)
    {
        ///remove user from array $this->users_x
        $this->users_x = array_filter($this->users_x, function ($user) use ($userId) {
            return $user->user_id != $userId;
        });

        $this->searchUser($this->search_user, 'Reviewer');
    }


    public function cancelSelecet() {}

    public function assignEditor(JournalUser $user)
    {
        $user->article_journal_users()->attach($this->record->id);

        $status = $this->articleStatus('008');

        $this->record->update([
            'article_status_id' => $status->id,
            'deadline'          => Carbon::now()->addDays($status->max_days)
        ]);

        //updating notification
        $note = $this->record->notifications()->where('journal_user_id', $this->journal->journal_us()->where('user_id', auth()->user()->id)->first()->id);

        if ($note->exists()) {
            $note->first()->update([
                'status' => 0
            ]);
        }

        Notification::updateOrCreate([
            'article_id'      => $this->record->id,
            'journal_user_id' => $user->id
        ], [
            'article_id'      => $this->record->id,
            'journal_user_id' => $user->id,
            'status'          => 1
        ]);


        session()->flash('response', [
            'status'  => 'success',
            'message' => $user->user->last_name . ' is successfully assigned as Associate Editor to Followup on this Manuscript'
        ]);

        if (ReviewMessage::where('category', 'Article Assignment')->exists()) {
            Mail::to($user->user->email)
                ->send(new ArticleAssignment($this->record));
        }

        $this->closeDrawerA();
    }

    public function removeUser(JournalUser $user)
    {
        if ($user->delete()) {
            session()->flash('response', [
                'status'  => 'success',
                'message' => 'This user is successfully removed from this journal'
            ]);
        }
    }

    public $start_date;
    public $end_dates = [];

    public $scope = false;
    public $methodology = false;
    public $tech_complete = false;
    public $noverity = false;
    public $prior_publication = false;


    public function sendToReviewer()
    {
        $status = $this->articleStatus('010');
        $this->record->update([
            'article_status_id' => $status->id,
            'deadline'          => Carbon::now()->addDays($status->max_days)
        ]);

        $note = $this->record->notifications()->where('journal_user_id', $this->journal->journal_us()->where('user_id', auth()->user()->id)->first()->id);

        if ($note->exists()) {
            $note->first()->update([
                'status' => 0
            ]);
        }

        foreach ($this->users_x as $key => $user_s) {
            $user_s->article_journal_users()->sync([$this->record->id => [
                'review_start_date' => now(),
                'review_end_date'   => Carbon::now()->addDays($status->max_days),
                'review_status'     => 'pending'
            ]], false);


            if (ReviewMessage::where('category', 'Review Request')->count() > 0) {
                Mail::to($user_s->user->email)
                    ->send(new ReviewRequest($this->record, $user_s));
            }
        }

        $this->users_x = [];

        session()->flash('response', [
            'status'  => 'success',
            'message' => 'Review request is successfully sent to reviewer'
        ]);
    }

    public function resendEmailLink($userUuid)
    {

        $status = $this->articleStatus('010');
        $user_s = JournalUser::with('user')
            ->whereHas('user', fn($q) => $q->where('user_id', $userUuid))
            ->first();

        if (!$user_s) {
            session()->flash('error', 'Reviewer not found.');
            return;
        }

        // Update pivot (start and end date)
        $user_s->article_journal_users()->sync([
            $this->record->id => [
                'review_start_date' => now(),
                'review_end_date' => now()->addDays($status->max_days),
                'review_status' => 'pending'
            ]
        ], false);


        // Send the email if review message exists
        if (ReviewMessage::where('category', 'Review Request')->exists()) {
            Mail::to($user_s->user->email)
                ->send(new ReviewRequest($this->record, $user_s));
        }

        session()->flash('response', [
            'status' => 'success',
            'message' => 'Review request resent to ' . $user_s->user->email,
        ]);
    }





    public $editorial;
    public $type_setting;


    public function publicationCheck()
    {
        $this->validate([
            'editorial'       => 'required',
            'type_setting'    => 'required',
            'manuscript_file' => 'required|file|max:9024|mimes:pdf|mimetypes:application/pdf',
            'start_page'      => 'required|integer',
            'end_page'        => 'required|integer',
        ]);


        if ($this->manuscript_file) {
            $_name = $this->manuscript_file->getClientOriginalName();
            $_type = $this->manuscript_file->getClientOriginalExtension();

            $this->manuscript_file->storeAs('publications/', $this->record->paper_id . '.pdf');
        }


        $status = $this->articleStatus('011');
        $this->record->update([
            'editorial'         => $this->editorial,
            'type_setting'      => $this->type_setting,
            'manuscript_file'   => $this->record->paper_id . '.pdf',
            'start_page'        => $this->start_page,
            'end_page'          => $this->end_page,
            'article_status_id' => $status->id,
            'deadline'          => Carbon::now()->addDays($status->max_days)
        ]);


        session()->flash('response', [
            'status'  => 'success',
            'message' => 'This manuscript is ready for publication'
        ]);
    }


    public $confirm_publish = false;

    public function confirmPublish(Article $article)
    {
        $this->record = $article;
        $this->confirm_publish = true;
    }


    public function publish()
    {
        $status = $this->articleStatus('014');
        $this->record->update([
            'article_status_id' => $status->id,
            'publication_date'  => now()
        ]);

        session()->flash('response', [
            'status'  => 'success',
            'message' => 'This manuscript is Successifully published online first'
        ]);
    }




    public $reviewOption;
    public $reviewComment;
    public $sections = [];
    public $reviewerFeedback;
    public $review_decision;

    public function reviewFeedback(User $reviewer)
    {
        $this->reviewOption     = ArticleReview::where('article_id', $this->record->id)->where('user_id', $reviewer->id)->pluck('review_section_option_id', 'review_section_query_id')->toArray();
        $this->reviewComment    = ReviewSectionsComment::where('article_id', $this->record->id)->where('user_id', $reviewer->id)->pluck('comment', 'review_section_id')->toArray();
        $this->sections         = ReviewSectionsGroup::all();

        $journal_user = $reviewer->journal_us()->whereHas('roles', function ($query) {
                                $query->where('name', 'Reviewer');
                            })->where('journal_id', $this->record->journal_id)->first();

        $article_juser = $journal_user->article_journal_users()->where('article_id', $this->record->id)->first();

        $this->review_decision  = $article_juser->pivot->review_decision;

        $this->reviewerFeedback = true;

    }





    public $send = [];
    public $review_status;
    public $editor_comments;

    public function generalReviewStatus()
    {
        $this->validate([
            'review_status' => 'required|in:018,019,020,015'
        ]);


        $status = $this->articleStatus($this->review_status);
        $this->record->update([
            'article_status_id' => $status->id,
            'deadline'          => Carbon::now()->addDays($status->max_days)
        ]);

        Mail::to($this->record->author->email)
            ->send(new ReviewStatus($this->record, $this->editor_comments, array_keys($this->send, true, true)));


        if ($this->review_status == "018") {
            $this->accept_for_production = false;
        } else {

            //updating notification
            $note = $this->record->notifications()->where('journal_user_id', $this->journal->journal_us()->where('user_id', auth()->user()->id)->first()->id);

            if ($note->exists()) {
                $note->first()->update([
                    'status' => 0
                ]);
            }

            $journal_user = $this->journal->journal_us()->where('user_id', $this->record->user_id)->first();
            Notification::updateOrCreate([
                'article_id'      => $this->record->id,
                'journal_user_id' => $journal_user->id
            ], [
                'article_id'      => $this->record->id,
                'journal_user_id' => $journal_user->id,
                'status'          => 1
            ]);
        }


        session()->flash('response', [
            'status'  => 'success',
            'message' => 'General Review Status form Reviewers for this manuscript was Successfully sent to Author'
        ]);
    }




    public function returnManuscript($to = null)
    {
        $this->validate([
            'review_status' => 'required|in:018,019,020,015'
        ]);

        if ($to == 'managing_editor') {
            $status = $this->articleStatus('009');
        }

        $this->record->update([
            'article_status_id' => $status->id,
            'deadline'          => Carbon::now()->addDays($status->max_days)
        ]);


        ArticleComment::create(
            [
                'article_id'  => $this->record->id,
                'user_id'     => auth()->user()->id,
                'send_to'     => 'Chief Editor',
                'description' => $this->description
            ]
        );


        //updating notification
        $note = $this->record->notifications()->where('journal_user_id', $this->journal->journal_us()->where('user_id', auth()->user()->id)->first()->id);

        if ($note->exists()) {
            $note->first()->update([
                'status' => 0
            ]);
        }

        $journal_user = $this->journal->journal_us()->whereHas('roles', function ($query) {
            $query->where('name', 'Chief Editor');
        })->first();

        Notification::updateOrCreate([
            'article_id'      => $this->record->id,
            'journal_user_id' => $journal_user->id
        ], [
            'article_id'      => $this->record->id,
            'journal_user_id' => $journal_user->id,
            'status'          => 1
        ]);

        session()->flash('response', [
            'status'  => 'success',
            'message' => 'This manuscript is successfully returned to Managing Editor'
        ]);
    }


    public $accept_for_production = false;

    public function acceptedForProduction()
    {
        $this->accept_for_production = true;
    }


    public $typesetting  = false;
    public $copyediting  = false;
    public $formatting   = false;
    public $proofreading = false;
    public $manuscript_file;
    public $start_page;
    public $end_page;

    public function submitForPublication()
    {
        $this->validate([
            'proofreading'    => 'required',
            'formatting'      => 'required',
            'copyediting'     => 'required',
            'typesetting'     => 'required',
            'manuscript_file' => 'required|file|max:9024|mimes:pdf|mimetypes:application/pdf',
            'start_page'      => 'required|integer',
            'end_page'        => 'required|integer',
        ]);

        if ($this->manuscript_file) {
            $_name = $this->manuscript_file->getClientOriginalName();
            $_type = $this->manuscript_file->getClientOriginalExtension();

            $this->manuscript_file->storeAs('publications/', $this->record->paper_id . '.pdf');
        }

        $status = $this->articleStatus('013');

        $this->record->update([
            'proofreading'      => 1,
            'formatting'        => 1,
            'copyediting'       => 1,
            'typesetting'       => 1,
            'article_status_id' => $status->id,
            'manuscript_file'   => $this->record->paper_id . '.pdf',
            'start_page'        => $this->start_page,
            'end_page'          => $this->end_page,
            'deadline'          => Carbon::now()->addDays($status->max_days)
        ]);

        $this->closeDrawerG();

        session()->flash('response', [
            'status'  => 'success',
            'message' => 'This manuscript is Successfully set Pending for publication'
        ]);
    }





    public function acceptResubmission(Article $article)
    {
        $this->record = $article;
        $this->accept_for_production = true;
    }

    public $confirm_xs = false;
    public function confirmXS(Article $article)
    {
        $this->record = $article;
        $this->confirm_xs = true;
    }


    public function cancelSubmision()
    {
        if ($this->record->article_status->code == '002' || $this->record->article_status->code == '006') {
            $status = $this->articleStatus('012');
            $this->record->update([
                'article_status_id' => $status->id,
                'deadline'          => Carbon::now()->addDays($status->max_days)
            ]);

            session()->flash('response', [
                'status'  => 'success',
                'message' => 'This submision is Successfully cancelled'
            ]);
        } else {
            session()->flash('response', [
                'status'  => 'info',
                'message' => 'You can not cancel this submision the manuscript is already onprogress'
            ]);
        }

        $this->confirm_xs = false;
    }



    public function rejectManuscript()
    {
        $this->validate([
            'editor_comments' => 'required|string'
        ]);

        $status = $this->articleStatus('015');
        $this->record->update([
            'article_status_id' => $status->id,
            'deadline'          => Carbon::now()->addDays($status->max_days)
        ]);

        ArticleComment::create(
            [
                'article_id'  => $this->record->id,
                'user_id'     => auth()->user()->id,
                'description' => $this->editor_comments
            ]
        );

        session()->flash('response', [
            'status'  => 'info',
            'message' => 'This manuscript is rejected and sent back to author'
        ]);

        $this->closeDrawerH();
    }


    public function removeEditor($data)
    {
        if ($this->record->article_journal_users()->detach($data)) {
            session()->flash('response', [
                'status'  => 'info',
                'message' => 'The Associate Editor is now Removed From this Manuscript'
            ]);
        }
    }



    public $dropManuscriptModal = false;
    public function dropManuscript(Article $article)
    {
        $this->record = $article;
        $this->dropManuscriptModal = true;
    }


    public function confirmDrop()
    {
        $status = $this->articleStatus('021');
        $this->record->update([
            'article_status_id' => $status->id
        ]);

        session()->flash('response', [
            'status'  => 'info',
            'message' => 'This Manuscript is dropped and sent back to Manuscripts with Decisions'
        ]);
    }
}
