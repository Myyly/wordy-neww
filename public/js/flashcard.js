$("#checkAllBtn").click(function () {
    $(".definition-col").toggle(); 
    $(".definition-header").toggle();
});
$(document).ready(function () {
    $('#deleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let deleteUrl = "{{ route('delete', ':id') }}".replace(':id', id);
        $('#deleteForm').attr('action', deleteUrl);
    });
});
$(document).ready(function () {
    $('#addModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('list_id');
        $('#id_list').val(id);
    });
});
$(document).ready(function () {
    $('#edit_listModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('list_id');
        let title = button.data('word_title');
        let description = button.data('word_description');
         $('#title').val(title);
         $('#description').val(description);
         $('#list_id').val(id);
       let edit_listUrl = "{{ route('edit_list', ':id') }}".replace(':id', id);
        $('#edit_listForm').attr('action', edit_listUrl);
    });
});
$(document).ready(function () {
    $('#editModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let word = button.data('word');
        let definition = button.data('definition');
        let word_type = button.data('word_type');
        let pronunciaton = button.data('pronunciaton');

        let editUrl = "{{ route('edit', ':id') }}".replace(':id', id);
        $('#editForm').attr('action', editUrl);
        $('#word').val(word);
        $('#definition').val(definition);
        $('#word_type').val(word_type);
        $('#pronunciaton').val(pronunciaton);
    });
});
function speak(text) {
    if ('speechSynthesis' in window) {
        speechSynthesis.cancel();

        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'en-US'; // Ngôn ngữ

        // Lấy danh sách giọng
        let voices = speechSynthesis.getVoices();

        // Nếu chưa có giọng (vì voices load bất đồng bộ), lắng nghe sự kiện voiceschanged
        if (voices.length === 0) {
            speechSynthesis.addEventListener('voiceschanged', () => {
                voices = speechSynthesis.getVoices();
                setVoiceAndSpeak(voices, utterance);
            });
        } else {
            setVoiceAndSpeak(voices, utterance);
        }

        // Hàm chọn giọng và phát âm
        function setVoiceAndSpeak(voicesList, utter) {
            // Ví dụ chọn giọng tiếng Anh nữ có tên chứa 'Google' (thường có trên Chrome)
            const selectedVoice = voicesList.find(v => v.lang === 'en-US' && v.name.includes('Google'));

            if (selectedVoice) {
                utter.voice = selectedVoice;
            } else {
                // Nếu không tìm được giọng Google, chọn giọng đầu tiên cùng ngôn ngữ
                utter.voice = voicesList.find(v => v.lang === 'en-US') || null;
            }

            utter.rate = 0.7;  // tốc độ đọc
            utter.pitch = 1.0; // cao độ
            utter.volume = 0.6;  // âm lượng

            speechSynthesis.speak(utter);
        }
    } else {
        alert("Trình duyệt không hỗ trợ phát âm!");
    }
}