

<!-- FOOTER -->
<footer class="footer mt-auto py-3">
    <div class="container">
        <p>&copy; <?php echo date("Y");?> carobd.pl for K27@WSB</p>
        <!-- to top arrow start -->
        <a class="page-scroll" href="#top">
            <div class="to-top-arrow">
                <i class="fas fa-chevron-up"></i>
            </div>
        </a>
        <!-- to top arrow end -->
    </div>

</footer>
</main>

<!-- Reservation form modal-->
<div class="modal fade" id="reservationModal" tabindex="-1" role="dialog" aria-labelledby="reservationModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reservationModalLabel">&nbsp;</h5>  <!--  &nbsp for w3c validator error if empty - value is assigned by jQuery on open modal -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="reservationForm" id="reservationForm">
                    <div class="form-group">
                        <label for="carMark">Marka:</label>
                        <select class="form-control" name="carMark" id="carMark" required>
                            <option value="">-</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="carModel">Model:</label>
                        <select class="form-control" name="carModel" id="carModel" required>
                            <option value="">-</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="carGeneration">Rok produkcji:</label>
                        <select class="form-control" name="carGeneration" id="carGeneration" >
                            <option value="">-</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="carSerie">Nadwozie:</label>
                        <select class="form-control" name="carSerie" id="carSerie" >
                            <option value="">-</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="carModification">Silnik:</label>
                        <select class="form-control" name="carModification" id="carModification" >
                            <option value="">-</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="carService">Rodzaj usługi:</label>
                        <select multiple class="form-control" name="carService" id="carService" required>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="carRegNo">Nr rej.</label>
                        <input type="text" class="form-control" id="carRegNo" name="carRegNo" placeholder="Wpisz nr rejestracji" required>
                    </div>

                    <div class="form-group">
                        <label for="cusName">Imię i nazwisko</label>
                        <input type="text" class="form-control" id="cusName" name="cusName" placeholder="Podaj imię i nazwisko" required>
                    </div>

                    <div class="form-group">
                        <label for="cusPhone">Nr kontaktowy</label>
                        <input type="tel" class="form-control" id="cusPhone" name="cusPhone" placeholder="format: 501-501-501" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" required>
                    </div>

                    <input type="hidden" name="f_hid" id="f_hid" value="">
                    <input type="hidden" name="f_year" id="f_year" value="">
                    <input type="hidden" name="f_month" id="f_month" value="">
                    <input type="hidden" name="f_day" id="f_day" value="">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                    <button id="sendReservation" type="submit" class="btn btn-warning submitForm">Zarezerwuj</button>
                    <button id="calculate" type="submit" class="btn btn-success float-right submitForm">Podlicz koszty</button>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal info  -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">&nbsp;</h5>  <!--  &nbsp for w3c validator error if empty - value is assigned by jQuery on open modal -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="infoMsg">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal check phone of reservations -->
<div class="modal fade" id="checkModal" tabindex="-1" role="dialog" aria-labelledby="checkModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sprawdź termin wizyty</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="checkMsg">
                <form class="checkForm" id="checkForm">

                    <div class="form-group">
                        <label for="custPhone">Nr kontaktowy</label>
                        <input type="tel" class="form-control" id="custPhone" name="custPhone" placeholder="format: 501-501-501" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" required>
                    </div>


                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-warning">Sprawdź</button>

                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal check code of reservations -->
<div class="modal fade" id="checkModalPhone" tabindex="-1" role="dialog" aria-labelledby="checkModalPhone" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sprawdź termin wizyty</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="checkMsg">
                <form class="checkFormCode" id="checkFormCode">

                    <div class="form-group">
                        <label for="custPhone">Podaj SMS kod</label>
                        <input type="text" class="form-control" id="custPhoneCode" name="custPhoneCode" placeholder="" pattern="[0-9]{4,}" required autofocus>
                    </div>

                    <input type="hidden" id="phoneToCheck" name="phoneToCheck" value="">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-warning">Sprawdź</button>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal display info of reservations -->
<div class="modal fade" id="resModal" tabindex="-1" role="dialog" aria-labelledby="resModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terminy wizyt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="resMsg">
            </div>
        </div>
    </div>
</div>

<!-- Modal display info of reservations costs-->
<div class="modal fade" id="calModal" tabindex="-1" role="dialog" aria-labelledby="resModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="calHeader"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="calMsg">
                <div id="calServiceName"></div>
                <div id="calServicePrice"></div>
                <div>
                    <div id="calServiceTotal" class="calModalData">Razem</div>
                    <div id="calServiceSum" class="calModalData"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- jQuery JS -->
<script src="/assets/js/jquery-3.4.1.js"></script>

<!-- bootstrap JS -->
<script src="/assets/js/bootstrap.js"></script>

<!-- custom JS -->
<script src="/assets/js/custom.js"></script>

<!-- form JS-->
<script src="/assets/js/form.js"></script>

<!-- calendar JS-->
<script src="/assets/js/calendar.js"></script>