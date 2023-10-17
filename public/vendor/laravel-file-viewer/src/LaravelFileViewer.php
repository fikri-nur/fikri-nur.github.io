<?php

namespace LaravelFileViewer;

use App\Models\File;

class LaravelFileViewer
{
  public function show(File $file, $file_data = [])
  {
    $filename = $file->name;
    $file_url = asset($file->file_link);
    $type = $file->mime_type;
    $metadata = [
      'size' => $file->original_size,
    ];
    
    $icon_class = $this->getIconClass($type);
    $filesizenyteformat = $this->formatBytes($metadata['size']);

    $viewdata = compact('filename', 'file', 'file_url', 'type', 'file_data', 'metadata', 'icon_class', 'filesizenyteformat');

    switch (explode('/', $type)[0]) {
      case 'image':
        return view('laravel-file-viewer::previewFileImage', $viewdata);
        break;
      case 'audio':
        return view('laravel-file-viewer::previewFileAudio', $viewdata);
        break;
      case 'video':
        return view('laravel-file-viewer::previewFileVideo', $viewdata);
        break;

      default:
        return view('laravel-file-viewer::previewFileOffice', $viewdata);
        // return view('laravel-file-viewer::previewFileGoogle',$viewdata);
        break;
    }
  }

  public function getIconClass($type)
  {
    switch (explode('/', $type)[0]) {
      case 'image':
        return 'assets/img/file-icon/image.png';
        break;

      case 'video':
        return 'assets/img/file-icon/video.png';
        break;

      case 'audio':
        return 'assets/img/file-icon/mp3.png';
        break;

      case 'application':
        switch (explode('/', $type)[1]) {
          case 'pdf':
            return 'assets/img/file-icon/pdf.png';
            break;
          case 'vnd.openxmlformats-officedocument.presentationml.presentation':
            return 'assets/img/file-icon/powerpoint.png';
            break;

          case 'vnd.openxmlformats-officedocument.wordprocessingml.document':
            return 'assets/img/file-icon/word.png';
            break;

          case 'msword':
            return 'assets/img/file-icon/word.png';
            break;

          case 'vnd.openxmlformats-officedocument.spreadsheetml.sheet':
            return 'assets/img/file-icon/excel.png';
            break;

          default:
            return 'assets/img/file-icon/text.png';
            break;
        }
        break;

      default:
        return 'assets/img/file-icon/text.png';
        break;
    }
  }
  function formatBytes($size, $precision = 2)
  {
    if ($size > 0) {
      $size = (int) $size;
      $base = log($size) / log(1024);
      $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
      return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
    } else {
      return $size;
    }
  }
}
