<form action="{{ route('generate_url.save') }}" method="post">
  @csrf
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Generate URL</h5>
    <button
      type="button"
      class="btn-close"
      data-bs-dismiss="modal"
      aria-label="Close"
    ></button>
  </div>
  <!-- Modal body -->
  <div class="modal-body">
    <div
      class="alert alert-danger alert-dismissible fade show"
      role="alert"
      style="display: none"
    >
      <button
        type="button"
        class="btn-close"
        data-dismiss="alert"
        aria-label="Close"
      >
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div
      class="alert alert-success alert-dismissible fade show"
      role="alert"
      style="display: none"
    >
      <button
        type="button"
        class="btn-close"
        data-dismiss="alert"
        aria-label="Close"
      >
        <span aria-hidden="true"></span>
      </button>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <div class="form-group">
          <label for="Parent">Route :</label>
          <br />
          <select
            style="width: 100%"
            class="form-control"
            id="route"
            name="route"
            required
          >
            {{-- <option value="">Select Route</option>
                        <option value="gmec">gmec</option>
                        <option value="olpcs">olpcs</option>
                        <option value="asiarope">asiarope</option>
                        <option value="gelosea">gelosea</option>
                        <option value="imocsea">imocsea</option>
                        <option value="imocsea_special">imocsea_special</option>
                        <option value="isocsea">isocsea</option>
                        <option value="imocsea+isocsea">imocsea+isocsea</option>
                        <option value="cambridge">cambridge</option>
                        <option value="huaxiacup">huaxiacup</option>
                        <option value="huaxiacup-ii">huaxiacup-II</option>
                        <option value="mathleague">mathleague</option>
                        <option value="mathleague-ii">mathleague-II</option>
                        <option value="reward">reward</option>
                        <option value="test_field">test_field</option>
                        <option value="neos">neo-science-olympiad</option>
                        <option value="neos-2">neo-science-school</option>
                        <option value="neos-2">neo-science-school</option>
                        <option value="huaxiacup-final-round">
                            China-Mathematical-Olympiad-Final
                        </option>
                        <option value="ihcmi">
                            international-hope-cup-mathematic-invitational
                        </option>
                        <option value="isc">International STEM competitions</option>
                        <option value="seacso">seacso</option>
                        <option value="copernicus">COPERNICUS OLYMPIAD</option>
                        <option value="coding-olympics">CODING OLYMPICS</option>
                        <option value="stemco_science">stemco_science</option>
                        <option value="advance_english_grammar">
                            advance_english_grammar
                        </option>
                        <option value="isocsea_imocsea_national_round_2025">
                            ( มา )isocsea_imocsea_national_round_2025
                        </option>
                        <option value="isocsea_imocsea_national_round">
                            ( ไม่มา ) isocsea_imocsea_national_round
                        </option>
                        <option value="admin-test-field">admin-test-field</option> --}}
            @foreach ($formRoutes as $formRoute)
              <option value="{{ $formRoute->slug }}">
                {{ $formRoute->form_name }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="form-group">
          <label for="Name">Referent Code:</label>
          {{-- <input type="text" class="form-control" name="referent_code" id="referent_code" required> --}}
          <select
            name="referent_code"
            id="referent_code"
            class="form-control"
            required
          >
            <option value="">Select Referent Code</option>
            @foreach ($referent_code as $item)
              <option value="{{ $item->referent_code }}">
                {{ $item->referent_code }} — ({{ $item->referent_name }})
              </option>
            @endforeach
          </select>
          <small class="form-text text-danger">* ตัวอย่าง : 1234567890</small>
        </div>
      </div>
    </div>
    <div class="form-group mt-3">
      <label for="Parent">Explain :</label>
      <br />
      <textarea
        name="comments"
        class="form-control"
        id="comments"
        rows="5"
      ></textarea>
    </div>
    <input
      type="hidden"
      name="user_id"
      id="user_id"
      value="{{ auth()->user()->id }}"
    />
  </div>
  <!-- Modal footer -->
  <div class="modal-footer">
    <button type="submit" class="btn btn-success">Save</button>
    <button
      type="button"
      class="btn btn-danger modelClose"
      data-bs-dismiss="modal"
    >
      Close
    </button>
  </div>
</form>
