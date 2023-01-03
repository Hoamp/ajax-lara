<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH POST</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="name" class="control-label">Title</label>
                    <input type="text" class="form-control" id="title">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title"></div>
                </div>
                

                <div class="form-group">
                    <label class="control-label">Content</label>
                    <textarea class="form-control" id="content" rows="4"></textarea>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-content"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-primary" id="store">SIMPAN</button>
            </div>
        </div>
    </div>
</div>

<script>
    // ketika tombol tambah dipencet
    $('body').on('click', '#btn-create-post', function () {

        // buka modal
        $('#modal-create').modal('show');
    });

    // create post aksi
    $('#store').click(function(e) {
        e.preventDefault();

        // mendefinisikan variabel
        let title   = $('#title').val();
        let content = $('#content').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        // mulai ajax dengan jquery
        $.ajax({

            url: `/posts`,
            type: "POST",
            cache: false,
            data: {
                "title": title,
                "content": content,
                "_token": token
            },
            success:function(response){

                // flash message ketika success
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });

                // data post
                let post = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.title}</td>
                        <td>${response.data.content}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                            <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                        </td>
                    </tr>
                `;
                
                // append / tambah ke table
                $('#table-posts').prepend(post);
                
                // membersihkan form
                $('#title').val('');
                $('#content').val('');

                // tutup modal
                $('#modal-create').modal('hide');
                

            },
            error:function(error){
                
                if(error.responseJSON.title[0]) {

                    // alert
                    $('#alert-title').removeClass('d-none');
                    $('#alert-title').addClass('d-block');

                    // message alert
                    $('#alert-title').html(error.responseJSON.title[0]);
                } 

                if(error.responseJSON.content[0]) {

                    // alert
                    $('#alert-content').removeClass('d-none');
                    $('#alert-content').addClass('d-block');

                    // message alert
                    $('#alert-content').html(error.responseJSON.content[0]);
                } 

            }

        });

    });

</script>