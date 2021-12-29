@extends('layouts.app')

@section('content')

    <div id="lists">
        @foreach($userPano->lists as $list)
            <div class="card col-2 float-start p-2 m-1" id="listDiv{{ $list->id }}">
                <div class="d-flex justify-content-between">
                    <div id="listNameDiv{{ $list->id }}"><label class="ml-5" for="listName"><b>{{ $list->name }}</b></label></div>
                    <label class="pr-5" for="editList">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre class="center-item">
                                    +
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" id="editListItem{{ $list->id }}" href="#" onclick="editListChange({{ $list->id }}, '{{ $list->name }}')">
                                        Düzenle
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="deleteList({{ $list->id }})">
                                        Sil
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </label>
                </div>

                <div id="list{{ $list->id }}" for="cards">
                    @foreach($list->cards as $card)
                        <div class="d-flex justify-content-between card-header" id="card{{ $card->id }}">
                            <label class="ml-5" for="cardName" id="cardName{{ $card->id }}" onclick="cardModal({{ $card->id }})">{{ $card->name }}</label>
                            <label class="pr-5" for="editCard">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre class="center-item">
                                            +
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="#" onclick="cardModal({{ $card->id }})">
                                                Düzenle
                                            </a>
                                            <a class="dropdown-item" href="#" onclick="deleteCard({{ $card->id }})">
                                                Sil
                                            </a>
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


    <!-- The Modal -->
    <div id="cardModal" class="modal">
        <!-- Modal content -->
        <div id="modal-content" class="modal-content">
            <div class="mb-1">Kart adı</div>
            <input type="text" for="card_title" id="card_title" name="card_title" class="card_title w-75" />
            <div class="mb-1 mt-1">Kart Açıklaması</div>
            <textarea id="card_content" name="card_content" class="card_content w-75" style="resize:none"></textarea>
            <label for="control-list" class="mt-2">Kontrol Listesi</label>
            <div id="controls"></div>
            <div id="controlDiv" class="mt-2">
                <a id="newControl" href="#">Bir öğe ekleyin</a>
            </div>
            <div class="text-center mt-2">
                <button id="editCard" class="btn btn-primary w-50 text-center mt-2">Kaydet</button>
                <button id="deleteCard" class="btn btn-primary w-50 text-center mt-2">Sil</button>
            </div>
        </div>
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
        $("#newListDiv").html('<input id="listName" name="listName" type="text" placeholder="Liste Adı" /><button class="btn btn-link" onclick="addNewList()">Ekle</button>');
        $("#listName").focus();
    };

    var addNewList = function () {

        var listName = document.getElementById('listName').value;

        $.ajax({
            type: 'POST',
            url: "{{ route('liste.store') }}",
            data: {
                userID: {{ $userPano->id }},
                listName: listName
            },
            success: function (data) {
                document.getElementById('lists').innerHTML += '<div class="card col-2 float-start p-2 m-1" id="listDiv' + data + '"><div class="d-flex justify-content-between"><div id="listNameDiv' + data + '"><label class="ml-5" for="listName"><b>' + listName + '</b></label></div><label class="pr-5" for="editList"><ul class="navbar-nav ms-auto"><li class="nav-item dropdown"><a id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>+</a><div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"><a class="dropdown-item" id="editListItem' + data + '" href="#" onclick="editListChange(' + data + ', \''+ listName + '\');">Düzenle</a><a class="dropdown-item" href="#" onclick="deleteList(' + data + ')">Sil</a></div></li></ul></label></div><div id="list' + data + '" for="cards"></div><div id="newCardDiv' + data + '" class="text-center"><button class="btn btn-link" for="addCard" onclick="cardDivChange(' + data + ')">+ Kart Ekle</button></div>';

                $("#newListDiv").html('<button class="btn btn-link float-end" id="addList" for="addList" onclick="listDivChange()">+ Yeni Liste Ekle</button>');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                errorThrown();
            }
        });
    }

    var editListChange = function(list_id, list_name){
        sessionStorage.setItem("editListName", list_id);
        document.getElementById('listNameDiv' + list_id).innerHTML = '<input id="editListInput" type="text" size=10 value="' + list_name + '" />';
        document.getElementById("editListInput").focus();
        var val = document.getElementById("editListInput").value;
        document.getElementById("editListInput").value = '';
        document.getElementById("editListInput").value = val;
    }

    var editList = function(list_id){
        var list_name = document.getElementById('editListInput').value;
        var url = '{{ route("liste.update", ":list_id") }}';
        url = url.replace(':list_id', list_id);

        $.ajax({
            type: 'PUT',
            url: url,
            data: {
                list_id: list_id,
                list_name: list_name,
            },
            success: function (data) {
                document.getElementById("editListInput").value = list_name;
                document.getElementById("listNameDiv" + list_id).innerHTML = '<label class="ml-5" for="listName"><b>' + list_name + '</b></label>';
                document.getElementById("editListItem" + list_id).setAttribute("onclick","editListChange(" + list_id + ",'" + list_name + "')");
                sessionStorage.removeItem("editListName");
                console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    var deleteList = function(list_id){
        var url = '{{ route("liste.destroy", ":list_id") }}';
        url = url.replace(':list_id', list_id);

        $.ajax({
            type: 'DELETE',
            url: url,
            data: {
                list_id: list_id,
            },
            success: function (data) {
                document.getElementById("listDiv" + list_id).outerHTML = "";
                console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    var cardDivChange = function (listid) {

        if(document.getElementById("cardName") !== document.activeElement && sessionStorage.getItem("lastid") != null){
            var lastCard = document.getElementById("newCardDiv" + sessionStorage.getItem("lastid"));
                lastCard.innerHTML = '<button class="btn btn-link" for="addCard" onclick="cardDivChange(' + sessionStorage.getItem("lastid") + ')">+ Kart Ekle</button>';
                sessionStorage.removeItem("lastid");
        }
        document.getElementById("newCardDiv" + listid).innerHTML = '<input id="cardName" name="cardName" type="text" placeholder="Kart Adı" size="10" /><button class="btn btn-link" onclick="addNewCard(' + listid + ')">Ekle</button>';
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

    var addNewCard = function (list_id) {

        var cardName = document.getElementById('cardName').value;

        $.ajax({
            type: 'POST',
            url: "{{ route('card.store') }}",
            data: {
                userID: {{ $userPano->id }},
                list_id: list_id,
                cardName: cardName
            },
            success: function (data) {
                document.getElementById('list' + list_id).innerHTML +=
                    '<div class="d-flex justify-content-between card-header" id="card' + data.id + '"><label class="ml-5" for="cardName" id="cardName' + data.id + '" onclick="cardModal(' + data.id + ')">' +
                    cardName + '</label><label class="pr-5" for="editCard"><ul class="navbar-nav ms-auto"><li class="nav-item dropdown"><a id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>+</a><div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"><a class="dropdown-item" href="#" onclick="cardModal(' + data.id + ')">Düzenle</a><a class="dropdown-item" href="#" onclick="deleteCard(' + data.id + ')">Sil</a></div></li></ul></label></div>';

                document.getElementById("newCardDiv" + list_id).innerHTML = '<button class="btn btn-link" for="addCard" onclick="cardDivChange(' + list_id + ')">+ Kart Ekle</button>';
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    var cardModal = function(card){
        var modal = document.getElementById("cardModal");
        var span = document.getElementsByClassName("close")[0];
        var url = '{{ route("card.show", ":card") }}';
        url = url.replace(':card', card);

        $.ajax({
            type: 'GET',
            url: url,
            data: {
                card: card
            },
            success: function (data) {
                document.getElementById("card_title").value = data.card.name;
                document.getElementById("card_content").value = data.card.content;
                document.getElementById("newControl").setAttribute("onclick","newControl(" + data.card.id + ");");
                document.getElementById("editCard").setAttribute("onclick","editCard(" + data.card.id + ");");
                document.getElementById("deleteCard").setAttribute("onclick","deleteCard(" + data.card.id + ");");

                $.each(data.controls, function(index, value) {
                    if(value.done == 1){
                        $("#controls").append("<div id='controlDiv" + value.id + "'><input id='control" + value.id + "' type='checkbox' onclick='checkControl(" + value.id + ")' checked='checked' /> <label id='controlChang"+ value.id + "'><label id='contLabel" + value.id + "' style='text-decoration: line-through'> " + value.name + "</label></label><label for='editControl'><ul class='navbar-nav ms-auto center-item'><li class='nav-item dropdown'><a id='navbarDropdown' href='#' role='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false' v-pre class='center-item'>+</a><div class='dropdown-menu dropdown-menu-right' aria-labelledby='navbarDropdown'><a class='dropdown-item' href='#' onclick='changeControlInput(" + value.id + ", \"" + value.name + "\")'>Düzenle</a><a class='dropdown-item' href='#' onclick='deleteControl(" + value.id + ")'>Sil</a></div></li></ul></label></div>");
                    }
                    else
                        $("#controls").append("<div id='controlDiv" + value.id + "'><input id='control" + value.id + "' type='checkbox' onclick='checkControl(" + value.id + ")' /> <label id='controlChang"+ value.id + "'><label id='contLabel" + value.id + "'> " + value.name + "</label></label><label for='editControl'><ul class='navbar-nav ms-auto center-item'><li class='nav-item dropdown'><a id='navbarDropdown' href='#' role='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false' v-pre class='center-item'>+</a><div class='dropdown-menu dropdown-menu-right' aria-labelledby='navbarDropdown'><a class='dropdown-item' href='#' onclick='changeControlInput(" + value.id + ", \"" + value.name + "\")'>Düzenle</a><a class='dropdown-item' href='#' onclick='deleteControl(" + value.id + ")'>Sil</a></div></li></ul></label></div>");
                });

                sessionStorage.setItem("lastCardid", card);

                modal.style.display = "block";

                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                        sessionStorage.removeItem("lastCardid");
                        document.getElementById("controlDiv").innerHTML = '<a id="newControl" href="#">Bir öğe ekleyin</a>';
                        document.getElementById("controls").innerHTML = '';
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    }

    var editCard = function(card_id){
        var card_title = document.getElementById('card_title').value;
        var card_content = document.getElementById('card_content').value;
        var url = '{{ route("card.update", ":card_id") }}';
        url = url.replace(':card_id', card_id);

        $.ajax({
            type: 'PUT',
            url: url,
            data: {
                card_id: card_id,
                card_title: card_title,
                card_content: card_content
            },
            success: function (data) {
                document.getElementById("cardName" + card_id).innerHTML = card_title;
                document.getElementById("cardModal").style.display = "none";
                document.getElementById("controlDiv").innerHTML = '<a id="newControl" href="#">Bir öğe ekleyin</a>';
                document.getElementById("controls").innerHTML = '';
                sessionStorage.removeItem("lastCardid");
                console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    var deleteCard = function(card_id){
        var url = '{{ route("card.destroy", ":card_id") }}';
        url = url.replace(':card_id', card_id);

        $.ajax({
            type: 'DELETE',
            url: url,
            data: {
                card_id: card_id,
            },
            success: function (data) {
                document.getElementById("card" + card_id).outerHTML = "";
                document.getElementById("cardModal").style.display = "none";
                sessionStorage.removeItem("lastCardid");
                console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    var newControl = function(card_id){
        $("#controlDiv").html('<input id="controlName" name="controlName" type="text" placeholder="Kontrol Öğesi" /><button class="btn btn-link" onclick="addNewControl(' + card_id + ')">Ekle</button>');
        $("#controlName").focus();
        sessionStorage.setItem("lastCardid", card_id);
    }

    var addNewControl = function(card_id){
        var controlName = document.getElementById('controlName').value;

        $.ajax({
            type: 'POST',
            url: "{{ route('control.store') }}",
            data: {
                card_id: card_id,
                controlName: controlName,
            },
            success: function (data) {
                $("#controls").append("<div id='controlDiv" + data + "'><input id='control" + data + "' type='checkbox' onclick='checkControl(" + data + ")' /> <label id='controlChang"+ data + "'><label id='contLabel" + data + "'> " + controlName + "</label></label><label for='editControl'><ul class='navbar-nav ms-auto center-item'><li class='nav-item dropdown'><a id='navbarDropdown' href='#' role='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false' v-pre class='center-item'>+</a><div class='dropdown-menu dropdown-menu-right' aria-labelledby='navbarDropdown'><a class='dropdown-item' href='#' onclick='changeControlInput(" + data + ", \"" + controlName + "\")'>Düzenle</a><a class='dropdown-item' href='#' onclick='deleteControl(" + data + ")'>Sil</a></div></li></ul></label></div>");
                $("#controlDiv").html('<a id="newControl" href="#" onclick="newControl(' + card_id + ')">Bir öğe ekleyin</a>');
                console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    var checkControl = function(control_id){
        var url = '{{ route("control.check", ":control_id") }}';
        url = url.replace(':control_id', control_id);

        $.ajax({
            type: 'POST',
            url: url,
            data: {
                control_id: control_id,
            },
            success: function (data) {
                if(data.done == 1){
                    document.getElementById("control" + data.id).checked = true;
                    document.getElementById("contLabel" + data.id).style["text-decoration"] = "line-through";
                }
                else
                    document.getElementById("contLabel" + data.id).style.removeProperty('text-decoration');

                console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    var changeControlInput = function(control_id, control_name){
        sessionStorage.setItem("editControlName", control_id);
        $("#controlChang" + control_id).html("<input id='editControlInput' type='text' size=10 value='" + control_name + "' />");
        document.getElementById("editControlInput").focus();
        var val = document.getElementById("editControlInput").value;
        document.getElementById("editControlInput").value = '';
        document.getElementById("editControlInput").value = val;
    }

    // var cardDivChange = function (listid) {

    //     if(document.getElementById("cardName") !== document.activeElement && sessionStorage.getItem("lastid") != null){
    //         var lastCard = document.getElementById("newCardDiv" + sessionStorage.getItem("lastid"));
    //             lastCard.innerHTML = '<button class="btn btn-link" for="addCard" onclick="cardDivChange(' + sessionStorage.getItem("lastid") + ')">+ Kart Ekle</button>';
    //             sessionStorage.removeItem("lastid");
    //     }
    //     document.getElementById("newCardDiv" + listid).innerHTML = '<input id="cardName" name="cardName" type="text" placeholder="Kart Adı" size="10" /><button class="btn btn-link" onclick="addNewCard(' + listid + ')">Ekle</button>';
    //     document.getElementById("cardName").focus();
    //     sessionStorage.setItem("lastid", listid);
    // };

    var editControl = function(control_id){
        var control_name = document.getElementById('editControlInput').value;
        var url = '{{ route("control.update", ":control_id") }}';
        url = url.replace(':control_id', control_id);

        $.ajax({
            type: 'PUT',
            url: url,
            data: {
                control_id: control_id,
                control_name: control_name
            },
            success: function (data) {
                $("#controlChang" + control_id).html("<label id='contLabel" + control_id + "'> " + control_name + "</label>");
                sessionStorage.removeItem("editControlName");
                console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    var deleteControl = function(control_id){
        var url = '{{ route("control.destroy", ":control_id") }}';
        url = url.replace(':control_id', control_id);

        $.ajax({
            type: 'DELETE',
            url: url,
            data: {
                control_id: control_id,
            },
            success: function (data) {
                document.getElementById("controlDiv" + control_id).outerHTML = "";
                console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    document.addEventListener('keydown', function (event) {
        let id = sessionStorage.getItem("lastid");
        let card_id = sessionStorage.getItem("lastCardid");

        if (event.key === "Escape") {
            document.getElementById("cardModal").style.display = "none";
            sessionStorage.removeItem("lastCardid");
            $("#controlDiv").html('<a id="newControl" href="#">Bir öğe ekleyin</a>');
            $("#controls").html('');
            $("#newListDiv").html('<button class="btn btn-link float-end" id="addList" for="addList" onclick="listDivChange()">+ Yeni Liste Ekle</button>');

            if(id != null)
                document.getElementById("newCardDiv" + id).innerHTML = '<button class="btn btn-link" for="addCard" onclick="cardDivChange(' + id +
                    ')">+ Kart Ekle</button>';
        }
        if (document.getElementById("listName") === document.activeElement && event.key === "Enter") {
            addNewList();
        }
        if (document.getElementById("editListInput") === document.activeElement && event.key === "Enter") {
            editList(sessionStorage.getItem("editListName"));
        }
        if (document.getElementById("editControlInput") === document.activeElement && event.key === "Enter") {
            editControl(sessionStorage.getItem("editControlName"));
        }
        if (document.getElementById("cardName") === document.activeElement && event.key === "Enter") {
            addNewCard(id);
        }
        if (document.getElementById("card_title") === document.activeElement && event.key === "Enter") {
            editCard(card_id);
        }
        if (document.getElementById("controlName") === document.activeElement && event.key === "Enter") {
            addNewControl(card_id);
        }
    });
</script>
@endsection
