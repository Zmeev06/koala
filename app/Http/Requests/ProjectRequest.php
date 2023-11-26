<?php

namespace App\Http\Requests;

use App\Models\ProjectList;
use Illuminate\Support\Facades\DB;
use App\Support\Requests\FormRequest;
use App\Notifications\ProjectAssigned;
use Illuminate\Support\Facades\Notification;

class ProjectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:190',
            'description' => 'nullable',
            'color' => 'required',
            'users' => 'required|array',
        ];
    }

    /**
     * Database Transaction.
     *
     * @return void
     */
    public function transaction()
    {
        DB::transaction(function () {
            unset($this->attributes['users']);
            unset($this->attributes['color']);
            $this->attributes['meta'] = ['color' => $this->request->color];

            $this->model->forceFill($this->attributes);
            $this->model->save();

            $this->model->users()->sync($this->request->users);

            if ($this->isPostRequest) {
                Notification::send($this->model->users, new ProjectAssigned($this->model));
            }
        });
    }


    public function createDefaultList(){

      $projectListBlocks = [
        [
          'name' => 'ЗАКРЕП',
          'order' => 0,
          'color' => '#F7D3D3'
        ],
        [
          'name' => 'БЭКЛОГ',
          'order' => 1,
          'color' => '#FFFCBC'
        ],
        [
          'name' => 'СПРИНТ',
          'order' => 2,
          'color' => '#7BD9FF'
        ],
        [
          'name' => 'В РАБОТЕ',
          'order' => 3,
          'color' => '#6094D5'
        ],
        [
          'name' => 'СДЕЛАНО',
          'order' => 4,
          'color' => '#79D587'
        ],
        [
          'name' => 'ТЕСТ',
          'order' => 5,
          'color' => '#FFF97E'
        ],
        [
          'name' => 'ДОДЕЛАТЬ',
          'order' => 6,
          'color' => '#F37D7D'
        ],
        [
          'name' => 'ИТОГ',
          'order' => 7,
          'color' => '#FFDAC1'
        ],
        [
          'name' => 'СДАНО',
          'order' => 8,
          'color' => '#C4BAED'
        ]
      ];


      foreach ($projectListBlocks as $block){
        ProjectList::create([
          'name' => $block['name'],
          'project_id' => $this->model->id,
          'order' => $block['order'],
          'color' => $block['color'],
        ]);
      }


    }

}
