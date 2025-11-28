<div class="tab-pane fade" id="pills-taxonomies" role="tabpanel" aria-labelledby="pills-taxonomies-tab">
    <div class="card p-3 shadow-sm">
        <h5 class="fw-semibold mb-1">Taxonomies Management</h5>
        <p class="text-muted small">Manage subjects, categories, and levels here.</p>
        <div class="container-fluid">
            <div class="row g-3">

                <!-- Educational Systems -->
                <div class="col-md-6">
                    <div class="taxonomy-card">
                        <h6>Educational Systems</h6>
                        <div id="eduList"></div>
                        <div class="add-input">
                            <input id="eduInput" type="text" class="form-control form-control-sm" name="eduInput"
                                placeholder="Add new educational systems">
                            <button class="btn btn-sm btn-secondary" onclick="addItem('eduList', 'eduInput')"><i
                                    class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Subjects -->
                <div class="col-md-6">
                    <div class="taxonomy-card">
                        <h6>Subjects</h6>
                        <div id="subjectList"></div>
                        <div class="add-input">
                            <input id="subjectInput" type="text" class="form-control form-control-sm"
                                name="subjectInput" placeholder="Add new subjects">
                            <button class="btn btn-sm btn-secondary" onclick="addItem('subjectList', 'subjectInput')"><i
                                    class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Examination Boards -->
                <div class="col-md-6">
                    <div class="taxonomy-card">
                        <h6>Examination Boards</h6>
                        <div id="boardList"></div>
                        <div class="add-input">
                            <input id="boardInput" type="text" class="form-control form-control-sm" name="boardList"
                                placeholder="Add new examination boards">
                            <button class="btn btn-sm btn-secondary" onclick="addItem('boardList', 'boardInput')"><i
                                    class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Sessions -->
                <div class="col-md-6">
                    <div class="taxonomy-card">
                        <h6>Sessions</h6>
                        <div id="sessionList"></div>
                        <div class="add-input">
                            <input id="sessionInput" type="text" class="form-control form-control-sm" name="sessionList"
                                placeholder="Add new sessions">
                            <button class="btn btn-sm btn-secondary" onclick="addItem('sessionList', 'sessionInput')"><i
                                    class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>