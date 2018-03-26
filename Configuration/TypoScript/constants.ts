
plugin.tx_assalat_timeslisting {
    view {
        # cat=plugin.tx_assalat_timeslisting/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:assalat/Resources/Private/Templates/
        # cat=plugin.tx_assalat_timeslisting/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:assalat/Resources/Private/Partials/
        # cat=plugin.tx_assalat_timeslisting/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:assalat/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_assalat_timeslisting//a; type=string; label=Default storage PID
        storagePid =
    }
}
