@extends('layouts.app')

@section('content')

    <div id="lists">
        @foreach(auth()->user()->lists as $list)
            <div class="card col-2 float-start p-2 m-1">
                <div class="d-flex justify-content-between">
                    <label class="ml-5" for="listName">{{ $list->name }}</label>
                    <label class="pr-5" for="editList">...</label>
                </div>

                <div id="list{{ $list->id }}" for="cards">
                    @foreach($list->cards as $card)
                        <div class="d-flex justify-content-between">
                            <label class="ml-5" for="cardName">{{ $card->name }}</label>
                            <label class="pr-5" for="editCard">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        ...
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            Düzenle
                                        </a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            Sil
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </label>
                        </div>
                    @endforeach
                </div>
                <div id="newCardDiv{{ $list->id }}" class="text-center">
                    <button class="btn btn-link" for="addCard"
                        onclick="cardDivChange({{ $list->id }})">{{ __('+ Kart Ekle') }}
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div id="newListDiv" class="card col-3">
        <button class="btn btn-link" id="addList" for="addList"
            onclick="listDivChange()">{{ __('+ Yeni Liste Ekle') }}</button>
    </div>

@endsection

@section('js')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var listDivChange = function () {
        document.getElementById("newListDiv").innerHTML =
            '<input id="listName" name="listName" type="text" placeholder="Liste Adı" /><button class="btn btn-link" onclick="addNewList()">Ekle</button>';
        document.getElementById("listName").focus();
    };

    var addNewList = function () {

        var listName = document.getElementById('listName').value;

        $.ajax({
            type: 'POST',
            url: "{{ route('liste.store') }}",
            data: {
                listName: listName
            },
            success: function (data) {
                document.getElementById('lists').innerHTML += '<div class="card col-2 float-start p-2 m-1"><div class="d-flex justify-content-between"><label class="ml-5" for="listName">' + listName + '</label><label class="pr-5" for="editList">...</label></div><div id="list' + data + '" for="cards"></div><div id="newCardDiv' + data + '" class="text-center"><button class="btn btn-link" for="addCard" onclick="cardDivChange(' + data + ')">+ Kart Ekle</button></div>';
                document.getElementById("newListDiv").innerHTML = '<button class="btn btn-link float-end" id="addList" for="addList" onclick="listDivChange()">+ Yeni Liste Ekle</button>';
            },
            error: function (jqXHR, textStatus, errorThrown) {
                errorFunction();
            }
        });
    }

    var cardDivChange = function (listid) {

        if(document.getElementById("cardName") !== document.activeElement && sessionStorage.getItem("lastid") != null){
            var lastCard = document.getElementById("newCardDiv" + sessionStorage.getItem("lastid"));
                lastCard.innerHTML = '<button class="btn btn-link" for="addCard" onclick="cardDivChange(' + sessionStorage.getItem("lastid") + ')">+ Kart Ekle</button>';
                sessionStorage.removeItem("lastid");
        }
        document.getElementById("newCardDiv" + listid).innerHTML = '<input id="cardName" name="cardName" type="text" placeholder="Kart Adı" /><button class="btn btn-link" onclick="addNewCard(' + listid + ')">Ekle</button>';
        document.getElementById("cardName").focus();
        sessionStorage.setItem("lastid", listid);
    };

    document.addEventListener('click', function(event) {
        if(document.getElementById("cardName") !== document.activeElement && sessionStorage.getItem("lastid") != null){
            var lastCard = document.getElementById("newCardDiv" + sessionStorage.getItem("lastid"));
                lastCard.innerHTML = '<button class="btn btn-link" for="addCard" onclick="cardDivChange(' + sessionStorage.getItem("lastid") + ')">+ Kart Ekle</button>';
                sessionStorage.removeItem("lastid");
        }
        if(document.getElementById("listName") !== document.activeElement){
            document.getElementById("newListDiv").innerHTML = '<button class="btn btn-link float-end" id="addList" for="addList" onclick="listDivChange()">+ Yeni Liste Ekle</button>';
        }
    });

    var addNewCard = function (listid) {

        var cardName = document.getElementById('cardName').value;

        $.ajax({
            type: 'POST',
            url: "{{ route('card.store') }}",
            data: {
                listid: listid,
                cardName: cardName
            },
            success: function (data) {
                document.getElementById('list' + listid).innerHTML +=
                    '<div class="d-flex justify-content-between"><label class="ml-5" for="cardName">' +
                    cardName + '</label><label class="pr-5" for="editCard">...</label></div>';
                document.getElementById("newCardDiv" + listid).innerHTML =
                    '<button class="btn btn-link" for="addCard" onclick="cardDivChange(' + listid +
                    ')">+ Kart Ekle</button>';
            },
            error: function (jqXHR, textStatus, errorThrown) {
                errorThrown();
            }
        });
    }

    document.addEventListener('keydown', function (event) {
        let id = sessionStorage.getItem("lastid");

        if (event.key === "Escape") {
            document.getElementById("newListDiv").innerHTML = '<button class="btn btn-link float-end" id="addList" for="addList" onclick="listDivChange()">+ Yeni Liste Ekle</button>';
            document.getElementById("newCardDiv" + id).innerHTML = '<button class="btn btn-link" for="addCard" onclick="cardDivChange(' + id +
                    ')">+ Kart Ekle</button>';
        }
        if (document.getElementById("listName") === document.activeElement && event.key === "Enter") {
            addNewList();
        }
        if (document.getElementById("cardName") === document.activeElement && event.key === "Enter") {
            addNewCard(id);
        }
    });

</script>
@endsection
