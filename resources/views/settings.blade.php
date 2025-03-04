@php
    function getClass(String $name, $errors): String {
        $baseClass = " shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline";
        $classValid = "text-gray-700";
        $classInvalid = "border border-red-500 text-red-500 placeholder-red-500";
        
        if (!empty($errors) && $errors->has($name)) {
            return $baseClass . $classInvalid;
        }
        return $baseClass . $classValid;
    }

    function getDefaultClass() {
        $baseClass = " shadow appearance-none border rounded w-full py-3 px-3 leading-tight focus:outline-none focus:shadow-outline";
        $classValid = "text-gray-700";
        return $classValid . $baseClass;
    }
@endphp

<x-layout>
    <form id="editDialog" class="hidden w-screen h-screen absolute z-20 bg-black/10">
        <div class="m-auto w-5/6 lg:w-2/6 h-max bg-white border-gray-500 rounded-md space-y-3 p-4">
            <div class="flex justify-between">
                <h2 id="title" class="text-sm lg:text-lg font-bold">Edit Something</h2>
                <x-heroicon-o-x-mark class="w-6 h-6 text-gray-500 cursor-pointer" onclick="closeEdit()" />
            </div>
            <input type="hidden" id="type">
            <input type="hidden" id="old" disabled />
            <input class="{{ getClass('input', $errors) }} text-xs lg:text-md" name="input" id="input" type="text" placeholder="new something" />
            <input class="hidden {{ getClass('confirmation', $errors) }} text-xs lg:text-md" name="value_confirmation" id="confirmation" type="text" placeholder="new something" />
            <div class="flex pt-4">
                <button class="relative text-sm lg:text-base bg-blue-500 rounded-lg py-1 px-3 lg:px-4 text-white ml-auto grid" style="grid-template-areas: stack" type="submit">
                    <span id="SubmitBtnLabel" style="grid-area: stack">Save</span>
                    <svg id="SubmitBtnLoading" class="invisible m-auto animate-spin h-5 w-5 text-white" style="grid-area: stack" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M4 12a8 8 0 0116 0" stroke="currentColor" stroke-width="4" fill="none"></path>
                    </svg>
                </button>
            </div>
        </div>
    </form>
    <div class="flex justify-between md:gap-8 pt-12 md:pt-16">
        <x-left />
        <div class="w-full md:w-3/5">
            <div class="mx-auto w-4/6 lg:w-5/6">
                <h1 class="text-md lg:text-2xl text-gray-700 font-bold">Settings</h1>
                <div class="flex mt-4 items-center justify-between lg:justify-start lg:gap-2">
                    <image id="icon" class="w-12 h-12 rounded-full" src="{{ $user["image_url"] ? asset('storage/icons/' . $user["image_url"]) : "/img/user.png" }}" alt="profile picture" />
                    <div class="flex items-center gap-1">
                        <div id="deleteIcon" class="{{ $user["image_url"] === null ? "hidden" : "" }}">
                            <x-heroicon-s-trash onclick="deleteFile()" class="w-5 h-5 lg:w-6 lg:h-6 text-red-400 hover:text-red-500 cursor-pointer" />
                        </div>
                        <input type="file" name="file" id="file" class="w-0 h-0 opacity-0" accept="image/*" onchange="handleFile(event)">
                        <button onclick="inputFile()" class="border border-blue-500 hover:bg-blue-500 rounded-lg px-2 lg:px-3 lg:py-1 text-sm text-blue-500 hover:text-white">Add</button>
                    </div>
                </div>
                <div class="flex flex-col gap-4 mt-4">
                    <div class="flex justify-between">
                        <p class="text-xs lg:text-base text-gray-500 leading-3">Name</p>
                        <div class="flex gap-2 cursor-pointer items-center" onclick="edit('name')">
                            <p id="name" class="text-xs lg:text-base leading-3">{{ $user['name'] }}</p>
                            <x-heroicon-o-chevron-right class="w-4 h-4" />
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-xs lg:text-base text-gray-500 leading-3">Username</p>
                        <div class="flex gap-2 cursor-pointer items-center" onclick="edit('username')">
                            <p id="username" class="text-xs lg:text-base leading-3">{{ $user['username'] }}</p>
                            <x-heroicon-o-chevron-right class="w-4 h-4" />
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-xs lg:text-base text-gray-500 leading-3">Description</p>
                        <div class="flex gap-2 cursor-pointer items-center" onclick="edit('description')">
                            <p id="description" class="text-xs lg:text-base leading-3">{{ $user['description'] }}</p>
                            <x-heroicon-o-chevron-right class="w-4 h-4" />
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-xs lg:text-base text-gray-500 leading-3">Email</p>
                        <div class="flex gap-2 cursor-pointer items-center" onclick="edit('email')">
                            <p id="email" class="text-xs lg:text-base leading-3">{{ $user['email'] }}</p>
                            <x-heroicon-o-chevron-right class="w-4 h-4" />
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-xs lg:text-base text-gray-500 leading-3">Password</p>
                        <x-heroicon-o-chevron-right class="w-4 h-4 cursor-pointer" onclick="edit('password')" />
                    </div>
                </div>
                <h2 class="text-sm sm:text-md lg:text-base font-bold mt-4">Advanced Settings</h2>
                <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="text-xs sm:text-md lg:text-base text-red-500 hover:text-red-700 mt-2" type="submit">Remove Account</button>
                </form>
            </div>
        </div>
        <x-trending />
    </div>

    <script>
        function inputFile() {
            const file = document.querySelector('#file');
            file.click();
        }

        function deleteFile() {
            const avatar = document.querySelector("#icon");
            avatar.src = "/img/user.png";
        
            fetch("/settings/icon", {
                method: "DELETE",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log("Icon removed");
                console.log(data);
            })
            .catch(error => {
                console.log("Error removing icon");
            });

            const deleteIcon = document.querySelector("#deleteIcon");
            if (!deleteIcon.classList.contains("hidden")) {
                deleteIcon.classList.add("hidden");
            }
        }

        function handleFile(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const url = e.target.result;
                    const avatar = document.querySelector("#icon");
                    avatar.src = url;
                }
                reader.readAsDataURL(file);

                const deleteIcon = document.querySelector("#deleteIcon");
                if (deleteIcon.classList.contains("hidden")) {
                    deleteIcon.classList.remove("hidden");
                }
            
                let formData = new FormData();
                formData.append("icon", file);
                
                fetch("/settings/icon", {
                    method: "POST",
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Icon uploaded");
                    console.log(data);
                })
                .catch(error => {
                    console.log("Error uploading icon");
                });
            }
        }

        function title(text) {
            return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
        }

        function edit(id) {
            const dialog = document.querySelector('#editDialog');
            dialog.reset();
            
            const old = document.querySelector('#old');
            const type = document.querySelector('#type');
            const titleElement = document.querySelector('#title');
            const input = document.querySelector('#input');
            const confirmation = document.querySelector('#confirmation');
            
            type.value = id;

            titleElement.innerText = `Edit ${title(id)}`;
            input.placeholder = `New ${title(id)}`;
            confirmation.placeholder = `New ${title(id)}`;

            if (id === "password") {
                confirmation.classList.add("block");
                confirmation.classList.remove("hidden");
            }

            if (id !== "password") {
                old.value = document.querySelector(`#${id}`).innerText;
            } else {
                old.classList.add("hidden");
            }

            dialog.classList.remove("hidden");
            dialog.classList.add("grid");
        }

        function closeEdit() {
            const input = document.querySelector('#input');
            const dialog = document.querySelector('#editDialog');
            const confirmation = document.querySelector('#confirmation');

            input.classList.remove("border-red-500");
            confirmation.classList.remove("border-red-500");

            confirmation.classList.add("hidden");
            confirmation.classList.remove("block");

            dialog.classList.add("hidden");
            dialog.classList.remove("grid");
        }
        
        const form = document.querySelector('#editDialog');
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            submit();
        });

        function toggleSubmitLoading() {
            const button = document.querySelector('#SubmitBtnLabel');
            const loading = document.querySelector('#SubmitBtnLoading');
            button.classList.toggle('invisible');
            loading.classList.toggle('invisible');
        }

        function submit() {
            event.preventDefault();

            const type = document.querySelector('#type');
            const input = document.querySelector('#input');
            const confirmation = document.querySelector('#confirmation');
            
            if (type !== "password" && old.value === input.value) {
                closeEdit();
                return;
            }

            toggleSubmitLoading();
            fetch("/settings", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: {{ Auth::user()->id }},
                    type: type.value,
                    value: input.value,
                    value_confirmation: confirmation.value
                })
            })
            .then(response => {
                if (response.status == 200) {
                    return response.json();
                } else if (response.status == 422) {
                    return response.json().then(data => {
                        throw new Error(`Validation failed`);
                    });
                } else {
                    throw new Error("Unexpected error");
                }
            })
            .then(data => {
                if (type.value !== "password") {
                    const old = document.querySelector(`#${type.value}`);
                    old.innerText = input.value;
                }
                setTimeout(() => {
                    toggleSubmitLoading();
                    closeEdit();
                }, 200);
            })
            .catch(error => {
                console.log(error);
                input.classList.add("border-red-500");
                confirmation.classList.add("border-red-500");
            });
        }
    </script>
</x-layout>
