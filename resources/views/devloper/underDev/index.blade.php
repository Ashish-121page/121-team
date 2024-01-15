<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vertical Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        body {
            background: #ddd2f9;
        }

        .vertical-navbar {
            width: auto;
            background-color: #1e1e1e;
            color: white;
            height: 100%;
            position: fixed;
            z-index: 1;
            overflow-x: hidden;
            padding-top: 20px;
        }



        .vtab-actions {
            background-color: #6666cc;
            height: 100vh;
        }

        .drawcanvas-container {
            display: flex;
            height: 100vh;
            width: 100vw;
            justify-content: center;
            align-self: center;
            align-items: center;
        }


        .drawcanvas {
            height: 500px !important;
            width: 1000px !important;
        }
    </style>
</head>

<body>

    <div class="container-fluid p-0 m-0 d-flex">
        <div class="d-flex align-items-start">
            <div class="nav flex-column nav-pills me-3 vertical-navbar" id="v-pills-tab" role="tablist"
                aria-orientation="vertical" style="gap: 40px">
                <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home"
                    aria-selected="true">Shape</button>
                <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile"
                    aria-selected="false">Profile</button>
                <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages"
                    aria-selected="false">Messages</button>
                <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings"
                    aria-selected="false">Settings</button>

                <button id="closepanel" class="btn btn-outline-danger" type="button">
                    Close Panel
                </button>

            </div>

            <div class="tab-content vtab-actions" id="v-pills-tabContent"
                style="width: 350px;margin: 0 100px;padding: 20px;display: nosne;">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                    aria-labelledby="v-pills-home-tab" tabindex="0">

                    <div class="d-flex gap-3 justify-content-between flex-wrap">
                        <button class="addcircle btn btn-secondary" type="button">Circle</button>

                        <button class="addRactangle btn btn-secondary" type="button">Ractangle</button>

                        <button class="addSquare btn btn-secondary" type="button">Square</button>

                        <button class="addTriangle btn btn-secondary" type="button">Triangle</button>

                        <button class="addHexagon btn btn-secondary" type="button">Hexagon</button>

                    </div>




                </div>
                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab"
                    tabindex="0">
                    2. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ipsam minus inventore ea eius in, dolor
                    reprehenderit quas voluptas quaerat assumenda sequi libero, tempora iusto facilis officia molestiae,
                    quam numquam commodi.
                </div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab"
                    tabindex="0">
                    3. Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima excepturi ullam, sunt molestiae
                    ducimus dicta facilis nostrum vel magnam libero, repudiandae debitis tenetur officiis eius esse
                    recusandae necessitatibus officia voluptatibus.
                </div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab"
                    tabindex="0">
                    4. Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex suscipit assumenda voluptas
                    praesentium quaerat corporis blanditiis laboriosam mollitia! Magnam quis iusto cum quas minus quos
                    dignissimos distinctio enim voluptate? Quod!
                </div>
            </div>
        </div>


        <div class="drawcanvas-container">
            <canvas id="drawcanvas" class="drawcanvas" width="800" height="600"></canvas>
        </div>

    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#closepanel").click(function() {
                $("#v-pills-tabContent").toggle();
            });

            var copiedObject;
            var copiedObjects = new Array();
            var state = [];
            var mods = 0;

            // Starting Febric
            var canvas = new fabric.Canvas('drawcanvas');
            canvas.setBackgroundColor('#ffffff', canvas.renderAll.bind(canvas));


            // Update state on each object modification
            canvas.on('object:modified', function() {
                updateState();
            });
            updateState();


            // Function to copy the selected object
            function copy() {
                canvas.getActiveObject().clone(function(cloned) {
                    copiedObject = cloned;
                });
            }
            // Function to paste the copied object
            function paste() {
                if (copiedObject) {
                    copiedObject.clone(function(clonedObj) {
                        canvas.add(clonedObj);
                        clonedObj.set({
                            left: clonedObj.left + 10,
                            top: clonedObj.top + 10,
                            evented: true,
                        });
                        if (clonedObj.type === 'activeSelection') {
                            // activeSelection needs a special case handling
                            clonedObj.canvas = canvas;
                            clonedObj.forEachObject(function(obj) {
                                canvas.add(obj);
                            });
                            // this should solve the unselectability
                            clonedObj.setCoords();
                        }
                        canvas.setActiveObject(clonedObj);
                        canvas.requestRenderAll();
                    });
                }
            }

            // Function to update the state
            function updateState() {
                if (mods < state.length) {
                    state = state.slice(0, mods + 1);
                }
                state.push(JSON.stringify(canvas));
                mods = state.length;
            }

            // Function to undo
            function undo() {
                if (mods > 1) {
                    canvas.clear().renderAll();
                    canvas.loadFromJSON(state[mods - 2], canvas.renderAll.bind(canvas));
                    mods -= 1;
                }
            }

            // Function to redo
            function redo() {
                if (mods < state.length - 1) {
                    canvas.clear().renderAll();
                    canvas.loadFromJSON(state[mods], canvas.renderAll.bind(canvas));
                    mods += 1;
                }
            }

            // Function to add a circle
            function addCircle() {
                var circle = new fabric.Circle({
                    radius: 50,
                    fill: 'red',
                    left: 100,
                    top: 100
                });
                canvas.add(circle);
            }


            function addHexagon() {
                var radius = 50; // Radius of the hexagon
                var sides = 6; // Number of sides (for a hexagon, this is 6)
                var angle = (2 * Math.PI) / sides; // The angle between the vertices

                // Calculating the vertices of the hexagon
                var points = [];
                for (var i = 0; i < sides; i++) {
                    points.push({
                        x: radius * Math.cos(angle * i),
                        y: radius * Math.sin(angle * i)
                    });
                }

                // Creating a polygon with the calculated vertices
                var hexagon = new fabric.Polygon(points, {
                    fill: 'orange',
                    left: 250,
                    top: 250,
                    stroke: 'black',
                    strokeWidth: 1
                });

                // Adding the hexagon to the canvas
                canvas.add(hexagon);
            }


            // Function to add a rectangle
            function addRectangle() {
                var rect = new fabric.Rect({
                    width: 100,
                    height: 70,
                    fill: 'green',
                    left: 150,
                    top: 150
                });
                canvas.add(rect);
            }

            // Function to add a Square
            function addSquare() {
                var rect = new fabric.Rect({
                    width: 70,
                    height: 70,
                    fill: 'orange',
                    left: 150,
                    top: 150
                });
                canvas.add(rect);
            }

            // Function to add a triangle
            function addTriangle() {
                var triangle = new fabric.Triangle({
                    width: 100,
                    height: 100,
                    fill: 'blue',
                    left: 200,
                    top: 200
                });
                canvas.add(triangle);
            }


            function deleteSelected() {
                var activeObjects = canvas.getActiveObjects();
                if (activeObjects.length) {
                    canvas.discardActiveObject(); // Clears the active selection
                    activeObjects.forEach(function(object) {
                        canvas.remove(object);
                    });
                }
            }


            // Adding a Circle
            $(".addcircle").click(function(e) {
                e.preventDefault();
                addCircle()
            });

            // Adding a Square
            $(".addSquare").click(function(e) {
                e.preventDefault();
                addSquare()
            });

            // Adding a Racangle
            $(".addRactangle").click(function(e) {
                e.preventDefault();
                addRectangle()
            });

            // Adding a Triangle
            $(".addTriangle").click(function(e) {
                e.preventDefault();
                addTriangle()
            });

            // Adding a Triangle
            $(".addHexagon").click(function(e) {
                e.preventDefault();
                addHexagon()
            });

            $(document).keydown(function(e) {
                console.log(event.which);
                if (e.key == 'Delete' || e.key == 'Backspace') {
                    deleteSelected()
                }

                if (e.key == 'C' && e.ctrlKey || e.key == 'c' && e.ctrlKey) {
                    copy()
                }

                if (e.key == 'V' && e.ctrlKey || e.key == 'v' && e.ctrlKey) {
                    paste()
                }

                if (e.key == 'Z' && e.ctrlKey || e.key == 'z' && e.ctrlKey) {
                    undo()
                }

                if (e.key == 'Y' && e.ctrlKey || e.key == 'y' && e.ctrlKey) {
                    redo()
                }



            });




        });
    </script>


</body>

</html>
