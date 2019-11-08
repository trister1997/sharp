<?php

namespace App\Sharp\Commands;

use App\User;
use Code16\Sharp\EntityList\Commands\EntityCommand;
use Code16\Sharp\EntityList\EntityListQueryParams;
use Code16\Sharp\Form\Fields\SharpFormCheckField;
use Illuminate\Support\Facades\Storage;

class ExportUsersCommand extends EntityCommand
{
    /**
     * @return string
     */
    public function label(): string
    {
        return "Export users as text file";
    }

    /**
     * @param EntityListQueryParams $params
     * @param array $data
     * @return array
     */
    public function execute(EntityListQueryParams $params, array $data = []): array
    {
        $filePath = "tmp/users " . now()->format("YmdHis") . ".txt";

        $users = ($data["sample"] ?? false)
            ? User::take(2)->get()
            : User::all();

        Storage::disk("local")->put(
            $filePath,
            $users
                ->map(function(User $user) {
                    return implode(",", $user->toArray());
                })
                ->implode("\n")
        );

        return $this->download($filePath, "users.txt", "local");
    }

    function buildFormFields()
    {
        $this->addField(
            SharpFormCheckField::make("sample", "Download a file sample")
        );
    }
}