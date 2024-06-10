<li><span class="caret">{{ $child_account->account_name }}</span>
    <span style="cursor: pointer;"
    onclick="editFunctipon({{ $child_account->id }})"><i
        class='bx bxs-pencil'></i></span>
    @if ($child_account->accounts)
        <ul class="nested">
            @foreach ($child_account->accounts as $childAccount)
                @include('admin.account.includes.child', ['child_account' => $childAccount])
            @endforeach
        </ul>
    @endif
<li>
