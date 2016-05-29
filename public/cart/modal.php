<style>
            #modal-cart .quantity { width:4em};
        </style>
        <div id="modal-cart" class="uk-modal">
            <div class="uk-modal-dialog"><a class="uk-modal-close uk-close"></a>
                <div class="uk-modal-header"><h3>Yours shopping cart</h3></div>
                <?php include __DIR__."/../cart/content.php";?>
                <div class="uk-modal-footer">
                    <button class="uk-button uk-modal-close uk-button-large">Close</button>
                    <a href="<?=URL_BASE?>order/" class="uk-button uk-button-primary uk-button-large uk-float-right checkout"> Checkout <i class="uk-icon-truck"></i></a>
                </div>
            </div>
        </div>