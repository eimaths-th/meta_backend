{{-- <!DOCTYPE html>
<html>
<head>
    <title>Route Control</title>
</head>
<body>
    <h1>Route Control Page</h1>

    <form action="{{ route('save_times') }}" method="post">
        @csrf

        <label for="route">Route:</label>
        <select name="route" id="route">
            <!-- Populate options with your route names -->
            <option value="gmec">gmec</option>
            <option value="olpcs">olpcs</option>
            <option value="asiarope">asiarope</option>
            <option value="gelosea">gelosea</option>
            <option value="imocsea">imocsea</option>
            <option value="isocsea">isocsea</option>
            <option value="imocsea+isocsea">imocsea+isocsea</option>
            <option value="cambridge">cambridge</option>

        </select>

        <label for="opening_time">Opening Time:</label>
        <input type="datetime-local" name="opening_time" id="opening_time">

        <label for="closing_time">Closing Time:</label>
        <input type="datetime-local" name="closing_time" id="closing_time">

        <button type="submit">Set Times</button>
    </form>
</body>
</html> --}}
<form action="{{ route('save_times') }}" method="post">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Set Time</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
        </button>
    </div>
    <!-- Modal body -->
    <div class="modal-body">
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">

            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"></span>
            </button>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="Parent">Route :</label><br>
                    <select style="width: 100%;" class="form-control" id="route" name="route" required>
                        <option value="">Select Route</option>
                        <option value="spelling-bee-islo">spelling-bee-islo</option>
                        <option value="advance_english_grammar">advance_english_grammar</option>
                        <option value="admin-test-field">admin-test-field</option>
                        {{-- <option value="gelosea">gelosea</option> --}}
                        <option value="isocsea-imocsea-national-round">(ไม่มา) isocsea-imocsea-national-round</option>
                        <option value="isocsea-imocsea-national-round-2025">(มา) isocsea-imocsea-national-round-2025</option>
                        {{-- <option value="asiarope">asiarope</option>
                        <option value="award-ceremony-isocsea">award-ceremony-isocsea</option>
                        <option value="cambridge">cambridge</option>
                        <option value="coding-olympics">CODING OLYMPICS</option>
                        <option value="copernicus">COPERNICUS OLYMPIAD</option>
                        <option value="gmec">gmec</option>
                        <option value="huaxiacup">huaxiacup</option>
                        <option value="huaxiacup-final-round">China-Mathematical-Olympiad-Final</option>
                        <option value="huaxiacup-ii">huaxiacup-II</option>
                        <option value="ihcmi">international-hope-cup-mathematic-invitational</option>
                        <option value="imocsea">imocsea</option>
                        <option value="imocsea+isocsea">imocsea+isocsea</option>
                        <option value="imocsea-national-round">imocsea-national-round</option>
                        <option value="imocsea_special">imocsea_special</option>
                        <option value="isc">International STEM competitions</option>
                        <option value="isocsea">isocsea</option>
                        <option value="isocsea-imocsea-national-round">(ไม่มา) isocsea-imocsea-national-round</option>
                        <option value="isocsea-imocsea-national-round-2025">(มา) isocsea-imocsea-national-round-2025</option>
                        <option value="mathleague">mathleague</option>
                        <option value="mathleague-ii">mathleague-II</option>
                        <option value="neos">neo-science-olympiad</option>
                        <option value="neos-2">neo-science-school</option>
                        <option value="olpcs">olpcs</option>
                        <option value="reward">reward</option>
                        <option value="seacso">seacso</option>
                        <option value="stemco_science">stemco_science</option>
                        <option value="test_field">test_field</option> --}}
                        @foreach ($formRoutes as $formRoute)
                            <option value="{{ $formRoute->slug }}">{{ $formRoute->form_name }}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="Name">Opening Time:</label>
                    <input type="datetime-local" class="form-control" name="opening_time" id="opening_time" required>
                    <small class="form-text text-danger">* กรุณาตั้งวันเปิดสนามเป็นวันที่ของเปิดวันแรกของกิจกรรม</small>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="Name">Closing Time:</label>
                    <input type="datetime-local" class="form-control" name="closing_time" id="closing_time" required>

                </div>
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="Parent">Explain :</label><br>
            <textarea name="comments" class="form-control" id="comments" rows="5"></textarea>

        </div>
        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id  }}">

    </div>
    <!-- Modal footer -->
    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-danger modelClose" data-bs-dismiss="modal">Close</button>
    </div>
</form>
