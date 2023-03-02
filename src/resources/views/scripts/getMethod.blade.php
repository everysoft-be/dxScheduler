<script>
    function _getMethod(location)
    {
        const path = location.split('.');

        let method = window;

        for (let index = 0; index < path.length; index++) {
            const segment = path[index];

            if (!method[segment]) {
                console.error("[Calendar::_getMethod()] Javascript function %s() is not present in the document !", location);

                return null;
            }

            method = method[segment];
        }

        return method;
    }
</script>