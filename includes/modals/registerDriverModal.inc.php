<script src="./scripts/registerDriver.js"></script>
<div class="modal fade" tabindex="-1" id="registerDriverModal">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-body w-100 p-4">
        <div class="container-fluid">
          <h4 style="font-weight:700;">Be a Driver Today!</h4>
          <form id="registerDriverForm" class="pt-3" method="post" enctype="multipart/form-data">
            <div class="row mb-4">
              <div class="col ">
                <label for="carNo" class="form-label ">Car Plate Number <i class="bi bi-123"></i></label>
                <input type="text" class="form-control" id="carNo" name="carNo" placeholder="Ex: ABC1234">
                <small id="carNoHelp" class="form-small-text"></small>
              </div>
              <div class="col">
                <label for="carType" class="form-label">Car Type <i class="bi bi-car-front-fill"></i></label>
                <input type="text" class="form-control" id="carType" name="carType" placeholder="Ex: Perodua Axia">
                <small id="carTypeHelp" class="form-small-text"></small>
              </div>
              <div class="col">
                <label for="carColour" class="form-label">Car Colour <i class="bi bi-palette"></i></label>
                <select name="carColour" id="carColour" class="form-select">
                  <option selected disabled>-Select-</option>
                  <option value="Red">Red</option>
                  <option value="Blue">Blue</option>
                  <option value="Green">Green</option>
                  <option value="White">White</option>
                  <option value="Black">Black</option>
                  <option value="Silver">Silver</option>
                  <option value="Gray">Gray</option>
                  <option value="Yellow">Yellow</option>
                  <option value="Orange">Orange</option>
                  <option value="Purple">Purple</option>
                  <option value="Brown">Brown</option>
                  <option value="Pink">Pink</option>
                </select>
              </div>
            </div>
            <div class="mb-4">
              <label for="licenseFiles" class="form-label">Driver License & Vehicle License <i class="bi bi-file-earmark-person"></i></label>
              <input type="file" class="form-control" id="licenseFiles" name="file" accept=".zip">
              <small id="fileNote" class="form-small-text">*Upload a zipped folder containing both documents [format accepted: .zip]</small>
            </div>
            <div class="mb-4">
              <label for="carRules" class="form-label">Car Rules <i class="bi bi-list-ol"></i></label>
              <textarea class="form-control" id="carRules" name="carRules" style="height: 8rem" placeholder="Ex: No food in my car!"></textarea>
              <small id="carRulesHelp" class="form-small-text"></small>
            </div>
            <p class="text-muted text-center">SunwayHoppers admins will go through your driver application</p>
            <div class="d-flex justify-content-center">
              <button type="submit" name="submitDriverBtn" id="submitDriverBtn" class="btn btn-primary shadow px-4" disabled>Apply</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
