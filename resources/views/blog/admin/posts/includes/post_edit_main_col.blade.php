@php
    /** @var \App\Models\BlogPost $item */
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @if($item->is_published)
                    Опубликовано
                @else
                    Черновик
                @endif
            </div>
            <div class="card-body">
                <div class="card-title"></div>
                <div class="card-subtitle md-2 text-muted"></div>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a href="#maindata" data-toggle="tab" role="tab" class="nav-link active">Основные</a>
                    </li>
                    <li class="nav-item">
                        <a href="#adddata" data-toggle="tab" role="tab" class="nav-link">Доп. данные</a>
                    </li>
                </ul>
                <br>
                <div class="tab-content">
                    <div class="tab-pane active" id="maindata" role="tabpanel">
                        <div class="form-group">
                            <label for="title">Заголовок</label>
                            <input name="title" value="{{ $item->title }}"
                                   id="title" type="text"
                                   class="form-control"
                                   minlength="3"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="content_raw">Статья</label>
                            <textarea name="content_raw" id="content_raw"
                                      rows="20"
                                      class="form-control">{{old('content_raw', $item->content_raw)}}</textarea>
                        </div>
                    </div>
                    <div class="tab-pane" id="adddata" role="tabpanel">
                        <div class="form-group">
                            <label for="category_id">Категория</label>
                            <select name="category_id" id="category_id"
                                    class="form-control" placeholder="Выберите категорию" required>
                                @foreach($categoryList as $categoryOption)
                                    <option value="{{ $categoryOption->id }}"
                                        @if($categoryOption->id == $item->category_id)
                                            selected
                                        @endif>
                                        {{ $categoryOption->id_title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="slug">Идентификатор</label>
                            <input name="slug" value="{{ $item->slug }}"
                                   id="slug"
                                   type="text"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="excerpt">Выдержка</label>
                            <textarea name="excerpt"
                                      id="excerpt"
                                      class="form-control"
                                      rows="3">{{ old('excerpt', $item->excerpt) }}</textarea>
                        </div>
                        <div class="form-check">
                            <!--для того что бы отправилось 0, ибо если нижний
                            не активирует пользователь, ничего не отправится-->
                            <input type="hidden"
                                    name="is_published"
                                    value="0">

                            <input type="checkbox"
                                    name="is_published"
                                    class="form-check-input"
                                    value="1"
                                    @if($item->is_published)
                                    checked="checked"
                                    @endif>
                            <label class="form_check_label" for="is_published">Опубликовано</label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
